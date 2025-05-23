<?php

namespace App\Sdk\Services\Base\Category;

use App\Sdk\Services\DetailService;

class CategoryDetailService extends DetailService
{
    protected $path = 'category';

    public function getResponseName()
    {
        return $this->getResponseData('name');
    }

    public function getResponseOrganizationId()
    {
        return $this->getResponseData('organizationId');
    }
}
