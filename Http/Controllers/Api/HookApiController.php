<?php

namespace Modules\Iwebhooks\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iwebhooks\Entities\Hook;
use Modules\Iwebhooks\Repositories\HookRepository;

class HookApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Hook $model, HookRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
