<?php

namespace Modules\Iwebhooks\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'iwebhooks__category_translations';
}
