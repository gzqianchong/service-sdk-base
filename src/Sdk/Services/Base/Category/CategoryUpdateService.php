<?php

namespace App\Sdk\Services\Base\Category;

use App\Sdk\Services\UpdateService;

class CategoryUpdateService extends UpdateService
{
    protected $path = 'category';

    public function setRequestName($name)
    {
        $this->addBody('name', $name);
        return $this;
    }

    public function setRequestOrganizationId($organizationId)
    {
        $this->addBody('organizationId', $organizationId);
        return $this;
    }

    public function getResponseName()
    {
        return $this->getResponseData('name');
    }

    public function getResponseOrganizationId()
    {
        return $this->getResponseData('organizationId');
    }
}
