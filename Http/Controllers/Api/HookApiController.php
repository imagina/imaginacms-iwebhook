<?php

namespace Modules\Iwebhooks\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iwebhooks\Entities\Hook;
use Modules\Iwebhooks\Repositories\HookRepository;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Iwebhooks\Services\DispatchService;

class HookApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Hook $model, HookRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }


  public function dispatch($criteria, Request $request)
  {
    $service = new DispatchService();

    //Get Parameters from request
    $params = $this->getParamsRequest($request);

    $data = $service->dispatchWebhook($criteria, $params);

    $status = $data['code'] ?? 200;
    if($status != 200) $status = $this->getStatusError($status);

    //Return response
    return response()->json($data['response'] ?? ["data" => "Request successful"], $status ?? 200);
  }


  public function tunnel(Request $request)
  {
    $service = new DispatchService();
    $webhookData = $request->input('attributes') ?? [];
    $data = [];

    try {
      $data = $service->getResponseWebhook((object)$webhookData);

      $status = $data['http_status'] ?? 200;
    } catch (\Exception $e) {
      //Save data of response
      $data['response'] = $e->getMessage();
      //Save data of code http
      $status = $this->getStatusError($e->getCode());
    }


  }

  /**
   * Only to testing webhook receive information
   */
  public function bulkChunkResult(Request $request)
  {

    try {

      if(app()->environment('local')){

        $data = $request->all();

        $response = [
          "data" => [
            'chunck_id' => $data['chunckId'],
            'totalItems' => $data['totalItems'],
            'completed' => $data['completed'],
            'errors' => $data['errors']
          ]
        ];

      }


    } catch (\Exception $e) {

      $status = $this->getStatusError($e->getCode());
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }

    //Return response
    return response()->json($response ?? ["data" => "Chunk Result Testing Received"], $status ?? 200);

  }


}
