<?php

namespace Modules\Iwebhooks\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class HookTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [
      'isLoading' => (int) $this->is_loading
    ];
  }
}
