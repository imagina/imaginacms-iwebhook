<?php

namespace Modules\Iwebhooks\Repositories\Cache;

use Modules\Iwebhooks\Repositories\HookRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheHookDecorator extends BaseCacheCrudDecorator implements HookRepository
{
    public function __construct(HookRepository $hook)
    {
        parent::__construct();
        $this->entityName = 'iwebhooks.hooks';
        $this->repository = $hook;
    }
}
