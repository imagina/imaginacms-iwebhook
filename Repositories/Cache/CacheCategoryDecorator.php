<?php

namespace Modules\Iwebhooks\Repositories\Cache;

use Modules\Iwebhooks\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'iwebhooks.categories';
        $this->repository = $category;
    }
}
