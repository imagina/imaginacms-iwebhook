<?php

namespace Modules\Iwebhooks\Services;

use Mockery\CountValidator\Exception;
use Modules\Iwebhooks\Entities\Log;
use Illuminate\Support\Facades\Process;

class DispatchService
{
  public function dispatchWebhook($criteria, $params)
  {
    $response = null;
    $model = null;
    $code = null;
    try {
      //Instance hook repository
      $modelRepository = app('Modules\Iwebhooks\Repositories\HookRepository');
      //Request data to Repository
      $model = $modelRepository->getItem($criteria, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      //Check if running the hook
      if ($model->is_loading == 1) throw new Exception('Item is running', 204);

      //Start sync
      $model->update(['is_loading' => 1]);
      $createLog = ['hook_id' => $model->id];

      $publicURL = setting("iwebhooks::urlPublicWebhook", null, false);

      if (!$publicURL) {
        $client = new \GuzzleHttp\Client();

        //Validate request
        try {
          $params = ["attributes" => $model->getAttributes()];

          //Response of hook
          $responseHook = $client->request('POST',
            "{$publicURL}/api/iwebhooks/v1/hooks/tunnel",
            [
              'body' => json_encode($params),
              'headers' => [
                'Content-Type' => 'application/json',
              ]
            ]
          );

          $createLog = array_merge($createLog, $this->processGuzzleResponse($responseHook));
        } catch (\Exception $e) {
          $createLog = array_merge($createLog, $this->processGuzzleResponse($e, true));
        }
      } else {
        $createLog = array_merge($createLog, $this->getResponseWebhook($model));
      }

      //Create log with statusCode, response and hookId
      Log::create($createLog);

      //Finish sync
      $model->update(['is_loading' => 0]);
      \Log::info("DispatchService::Hook With ID: {$model->id} run Successfully");
    } catch (\Exception $e) {
      \Log::info("DispatchService::Error: (Hook-{$model->id}) {$e->getMessage()}");
      $code = $e->getCode();
      if ($code != 204 && $model) $model->update(['is_loading' => 0]);
      $response = ["errors" => $e->getMessage()];
    }

    return ['response' => $response, 'code' => $code];
  }

  public function getResponseWebhook($data)
  {
    $response = [];
    if (!isset($data->http_method)) throw new Exception('Bad format data', 400);

    if ($data->http_method == 'PING') {
      // Get the IP and PORT
      $host = explode(":", $data->endpoint);
      $ip = $host[0] ?? null;
      $port = $host[1] ?? 80;

      $response = $this->isIPOnline($ip, $port);
    } else {
      $client = new \GuzzleHttp\Client();

      //Validate request
      try {
        //Response of hook
        $responseHook = $client->request($data->http_method,
          $data->endpoint,
          [
            "body" => json_encode($data->body),
            'headers' => $data->headers
          ]
        );

        $response = $this->processGuzzleResponse($responseHook);
      } catch (\Exception $e) {
        $response = $this->processGuzzleResponse($e, true);
      }

    }

    return $response;
  }

  public function isIPOnline($ip, $port = 80, $timeout = 10)
  {
    $connection = @fsockopen($ip, $port, $errno, $errstr, $timeout);

    if (is_resource($connection)) {
      // If the connection is successful, the IP is online
      fclose($connection); // Don't forget to close the connection
      return [
        'response' => 'Connect',
        'http_status' => 200
      ];
    } else {
      // If the connection fails, the IP might be offline, or the port is not open
      return [
        'response' => $errstr,
        'http_status' => $errno
      ];
    }
  }

  private function processGuzzleResponse($response, $isError = false)
  {
    if ($isError) {
      return [
        'response' => $response->getMessage() ?? 'No content', // Save data of response
        'http_status' => $response->getCode() // Save data of HTTP code
      ];
    } else {
      return [
        'response' => $response->getBody()->getContents() ?? 'No content', // Save data of response
        'http_status' => $response->getStatusCode() // Save data of HTTP code
      ];
    }
  }

}
