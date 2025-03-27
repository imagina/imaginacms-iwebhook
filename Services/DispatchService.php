<?php

namespace Modules\Iwebhooks\Services;

use Mockery\CountValidator\Exception;
use Modules\Iwebhooks\Entities\Hook;
use Modules\Iwebhooks\Entities\Log;
use Illuminate\Support\Facades\Process;

class DispatchService
{
  private $log = "Iwebhooks::Service|Dispatch|";

  public function dispatchWebhook($criteria, $params, $extraBody = null,$eventName = null)
  {
    $response = null;
    $model = null;
    $code = null;
    try {

      //Validation case bulk | The correct attribute was not obtained with the repository. Command had to be executed to clear cache
      if(!is_null($eventName) && str_contains($eventName,"custom.bulk")){

        $result = \DB::select('SELECT * FROM iwebhooks__hooks WHERE id = '.$criteria);
        $model = Hook::hydrate([$result[0]])->first();

      }else{

        //This is kept in case it's not bulk (Maybe delete in the future and leave just the top one)
        //Instance hook repository
        $modelRepository = app('Modules\Iwebhooks\Repositories\HookRepository');
        //Request data to Repository
        $model = $modelRepository->getItem($criteria, $params);
      }
      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      //Check if running the hook
      if ($model->is_loading == 1) throw new Exception('Item is running', 204);

      //Start sync
      if(is_null($eventName)) $model->update(['is_loading' => 1]);
      $createLog = ['hook_id' => $model->id];

      //Add extra body [IMPORTANT] after this line don't save/update directly this model
      if ($extraBody) $model->setAttribute('body', array_merge($extraBody, $model->body));

      $publicURL = setting("iwebhooks::urlPublicWebhook", null, false);

      if ($publicURL) {
        $client = new \GuzzleHttp\Client();

        //Validate request
        try {
          $params = ["attributes" => $model->getAttributes()];
          \Log::info($this->log.'Sending Post');
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
        try {
          $webhookResponse = $this->getResponseWebhook($model);
        } catch (\Exception $e) {
          $webhookResponse = $this->processGuzzleResponse($e, true);
        }
        $createLog = array_merge($createLog, $webhookResponse);
      }

      //Create log with statusCode, response and hookId
      $logCreated = app('Modules\Iwebhooks\Repositories\LogRepository')->create($createLog);

      //Finish sync
      Hook::where('id',$model->id)->update(['is_loading' => 0]);
      \Log::info("Iwebhooks:: Hook ID: {$model->id} run Successfully");
    } catch (\Exception $e) {
      \Log::error($this->log."".$e->getMessage());
      $code = $e->getCode();
      if ($code != 204 && $model) Hook::where('id',$model->id)->update(['is_loading' => 0]);
      $response = ["errors" => $e->getMessage()];
    }

    return ['response' => $response, 'code' => $code];
  }

  public function getResponseWebhook($data)
  {
    $response = [];
    if (!isset($data->http_method))
      return [
        'response' => 'Bad format data',
        'http_status' => 400
      ];

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
        \Log::info($this->log."ENDPOINT: ".$data->endpoint);
        //Response of hook
        $responseHook = $client->request($data->http_method,
          $data->endpoint,
          [
            "json" => $data->body,
            'headers' => $data->headers
          ]
        );

        $response = $this->processGuzzleResponse($responseHook);
      } catch (\Exception $e) {
        \Log::error($this->log."".$e->getMessage());
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

      $result = $response->getBody()->getContents();
      //It could arrive empty
      if(empty($result)){
        $result = 'No content';
      }else{
        $result = substr($result, 0, 65500);//Response Attr is a text in DB
      }
      return [
        'response' => $result, // Save data of response
        'http_status' => $response->getStatusCode() // Save data of HTTP code
      ];
    }
  }

}
