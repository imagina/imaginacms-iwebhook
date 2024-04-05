<?php

namespace Modules\Iwebhooks\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Hook extends CrudModel
{
  use Translatable;

  protected $table = 'iwebhooks__hooks';
  public $transformer = 'Modules\Iwebhooks\Transformers\HookTransformer';
  public $repository = 'Modules\Iwebhooks\Repositories\HookRepository';
  public $requestValidation = [
      'create' => 'Modules\Iwebhooks\Http\Requests\CreateHookRequest',
      'update' => 'Modules\Iwebhooks\Http\Requests\UpdateHookRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = [];
  protected $fillable = [];
}
