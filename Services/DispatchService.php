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
      $modelRepository = app('Modules\Iwebhooks\Repositories\HookRepository');
      //Request data to Repository
      $model = $modelRepository->getItem($criteria, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      if ($model->is_loading == 1) throw new Exception('Item is running', 204);

      //Start sync
      $model->update(['is_loading' => 1]);
      $client = new \GuzzleHttp\Client();

      //Response of hook
      $responseHook = $client->request($model->http_method,
        $model->endpoint,
        [
          "body" => json_encode($model->body),
          'headers' => $model->headers
        ]
      );

      //Create log with statusCode and response
      Log::create([
        'response' => $responseHook->getBody()->getContents() ?? 'No content',
        'http_status' => $responseHook->getStatusCode(),
        'hook_id' => $model->id
      ]);

      //Finish sync
      $model->update(['is_loading' => 0]);

    } catch (\Exception $e) {
      $code = $e->getCode();
      if ($code != 204 && $model) $model->update(['is_loading' => 0]);
      $response = ["errors" => $e->getMessage()];
    }

    return ['response' => $response, 'code' => $code];
  }
}
