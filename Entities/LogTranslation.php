<?php

namespace Modules\Iwebhooks\Entities;

use Illuminate\Database\Eloquent\Model;

class LogTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'iwebhooks__log_translations';
}
