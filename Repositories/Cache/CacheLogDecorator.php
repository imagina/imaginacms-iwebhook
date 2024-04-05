<?php

namespace Modules\Iwebhooks\Repositories\Cache;

use Modules\Iwebhooks\Repositories\LogRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheLogDecorator extends BaseCacheCrudDecorator implements LogRepository
{
    public function __construct(LogRepository $log)
    {
        parent::__construct();
        $this->entityName = 'iwebhooks.logs';
        $this->repository = $log;
    }
}
