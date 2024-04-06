<?php

namespace Modules\Iwebhooks\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Log extends CrudModel
{
  use Translatable;

  protected $table = 'iwebhooks__logs';
  public $transformer = 'Modules\Iwebhooks\Transformers\LogTransformer';
  public $repository = 'Modules\Iwebhooks\Repositories\LogRepository';
  public $requestValidation = [
      'create' => 'Modules\Iwebhooks\Http\Requests\CreateLogRequest',
      'update' => 'Modules\Iwebhooks\Http\Requests\UpdateLogRequest',
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
  protected $fillable = [
    'response',
    'http_status',
    'hook_id'
  ];

  public function hook()
  {
    return $this->belongsTo(Hook::class)->with('translations');
  }
}
