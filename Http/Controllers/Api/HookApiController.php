<?php

namespace Modules\Iwebhooks\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iwebhooks\Entities\Hook;
use Modules\Iwebhooks\Repositories\HookRepository;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class HookApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Hook $model, HookRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }


  public function runWebhook($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get Parameters from request
      $params = $this->getParamsRequest($request);

      //Request data to Repository
      $model = $this->modelRepository->getItem($criteria, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      if ($model->is_loading == 1) throw new Exception('Item is running', 204);

      $model->update(['is_loading' => 1]);
      $client = new \GuzzleHttp\Client();

      //Response
      $response = $client->request($model->http_method,
        $model->endpoint,
        [
          "body" => json_encode($model->body),
          'headers' => $model->headers
        ]
      );

      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
}
