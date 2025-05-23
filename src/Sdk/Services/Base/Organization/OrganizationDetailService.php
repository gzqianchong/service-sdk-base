<?php

namespace App\Sdk\Services\Base\Organization;

use App\Sdk\Services\DetailService;

class OrganizationDetailService extends DetailService
{
    protected $path = 'organization';

    public function getResponseName()
    {
        return $this->getResponseData('name');
    }
}
