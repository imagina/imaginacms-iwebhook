<?php

namespace Modules\Iwebhooks\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class LogTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [];
  }
}
