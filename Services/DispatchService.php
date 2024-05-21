<?php

namespace Modules\Iwebhooks\Services;

use Mockery\CountValidator\Exception;
use Modules\Iwebhooks\Entities\Log;

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

      if($model->http_method == 'PING') {
        // Get the IP and PORT
        $host = explode(":", $model->endpoint);
        $ip = $host[0] ?? null;
        $port = $host[1] ?? 80;

        $responsePing = $this->isIPOnline($ip, $port);
        $createLog = array_merge($createLog, $responsePing);
      } else {
        $client = new \GuzzleHttp\Client();

        //Validate request
        try {
          //Response of hook
          $responseHook = $client->request($model->http_method,
            $model->endpoint,
            [
              "body" => json_encode($model->body),
              'headers' => $model->headers
            ]
          );

          //Save data of response
          $createLog['response'] = $responseHook->getBody()->getContents() ?? 'No content';
          //Save data of code http
          $createLog['http_status'] = $responseHook->getStatusCode();
        } catch (\Exception $e) {
          //Save data of response
          $createLog['response'] = $e->getMessage() ?? 'No content';
          //Save data of code http
          $createLog['http_status'] = $e->getCode();
        }

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

  public function isIPOnline($ip, $port = 80, $timeout = 10) {
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
}