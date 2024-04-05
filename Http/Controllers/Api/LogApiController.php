<?php

namespace Modules\Iwebhooks\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iwebhooks\Entities\Log;
use Modules\Iwebhooks\Repositories\LogRepository;

class LogApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Log $model, LogRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
