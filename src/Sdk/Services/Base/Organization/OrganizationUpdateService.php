<?php

namespace App\Sdk\Services\Base\Organization;

use App\Sdk\Services\UpdateService;

class OrganizationUpdateService extends UpdateService
{
    protected $path = 'organization';

    public function setRequestName($name)
    {
        $this->addBody('name', $name);
        return $this;
    }

    public function getResponseName()
    {
        return $this->getResponseData('name');
    }
}
