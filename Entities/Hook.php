<?php

namespace Modules\Iwebhooks\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Ifillable\Traits\isFillable;
use Modules\Ilocations\Entities\Country;

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
    'category_id',
    'country_id',
    'redirect_link'
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

  public function lastLog() {
    return $this->hasOne(Log::class)->latestOfMany();
  }

  public function country()
  {
    return $this->belongsTo(Country::class)->with('translations');
  }

  public function getStatusInfoAttribute() {
    $defaultInfo = [
      'label' => trans('iwebhooks::cms.label.noRegistration'),
      'color' => '#6c757d',
      'class' => "offline",
      'textColor' => "#ffff"
    ];
    if ($this->relationLoaded('lastLog')) {
      if(isset($this->lastLog)) {
        if($this->lastLog->http_status == 200) {
          $defaultInfo = [
            'label' => trans('iwebhooks::cms.label.online'),
            'color' => '#28a745',
            'class' => "online",
            'textColor' => "#ffff"
          ];
        } else $defaultInfo['label'] = trans('iwebhooks::cms.label.offline');
      }
    }
    return (object) $defaultInfo;
  }

  public function getHookInfoAttribute() {
    $default = [
      'hook' => $this->endpoint,
      'port' => null,
    ];
    // Split the address by ":"
    $parts = explode(':', $this->endpoint);

    // If there's only one part, then no port is specified
    if ((bool)ip2long($parts[0]) && count($parts) > 1) {
      // Get the port from the second part
      $default = [
        'hook' => $parts[0],
        'port' => $parts[1],
      ];
    }

    return (object) $default;
  }
}
