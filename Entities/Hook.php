<?php

namespace Modules\Iwebhooks\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ifillable\Traits\isFillable;

class Hook extends CrudModel
{
  use Translatable, isFillable;

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
  public $translatedAttributes = [
    'title',
    'description',
    'action_label'
  ];
  protected $fillable = [
    'endpoint',
    'http_method',
    'body',
    'headers',
    'is_loading',
    'call_every_minutes',
    'category_id'
  ];

  protected $casts = [
    'body' => 'array',
    'headers' => 'array'
  ];

  public function category()
  {
    return $this->belongsTo(Category::class)->with('translations');
  }

  public function logs() {
    return $this->hasMany(Log::class);
  }

  public function log() {
    return $this->hasOne(Log::class)->latestOfMany();
  }
}
