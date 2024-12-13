<?php

namespace Modules\Iwebhooks\Entities;

use Modules\Core\Icrud\Entities\CrudStaticModel;

class EventType extends CrudStaticModel
{
  const CREATED = 1;
  const UPDATED = 2;
  const DELETED = 3;
  const BULK = 4;

  public function __construct()
  {
    $this->records = [
      self::CREATED => [
        'title' => trans('iwebhooks::statics.eventType.created'),
        'value' => 'eloquent.created:'
      ],
      self::UPDATED => [
        'title' => trans('iwebhooks::statics.eventType.updated'),
        'value' => 'eloquent.saved:'//Use this to catch also trnaslations changes
      ],
      self::DELETED => [
        'title' => trans('iwebhooks::statics.eventType.deleted'),
        'value' => 'eloquent.deleted:'
      ],
      self::BULK => [
        'title' => trans('iwebhooks::statics.eventType.bulk'),
        'value' => 'custom.bulk'
      ]
    ];
  }
}
