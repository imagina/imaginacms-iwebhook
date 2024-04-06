<?php

namespace Modules\Iwebhooks\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
  use Sluggable;

  public $timestamps = false;
  protected $fillable = [
    'title',
    'description',
    'slug'
  ];
  protected $table = 'iwebhooks__category_translations';

  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }
}
