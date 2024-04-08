<?php

namespace Modules\Iwebhooks\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Category extends CrudModel
{
  use Translatable;

  protected $table = 'iwebhooks__categories';
  public $transformer = 'Modules\Iwebhooks\Transformers\CategoryTransformer';
  public $repository = 'Modules\Iwebhooks\Repositories\CategoryRepository';
  public $requestValidation = [
      'create' => 'Modules\Iwebhooks\Http\Requests\CreateCategoryRequest',
      'update' => 'Modules\Iwebhooks\Http\Requests\UpdateCategoryRequest',
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
    'slug'
  ];
  protected $fillable = [
    'system_name',
    'status'
  ];
}
