<?php

namespace Modules\Iwebhooks\Entities;

use Illuminate\Database\Eloquent\Model;

class HookTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title',
      'description',
      'action_label'
    ];
    protected $table = 'iwebhooks__hook_translations';
}
