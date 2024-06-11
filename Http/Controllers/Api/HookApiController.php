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
}
