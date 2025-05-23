<?php

namespace App\Sdk\Services;

use Illuminate\Support\Arr;

class GetService extends Service
{
    protected $method = 'get';

    public function setRequestPage($page)
    {
        $this->addBody('page', $page);
        return $this;
    }

    public function setRequestPageSize($pageSize)
    {
        $this->addBody('pageSize', $pageSize);
        return $this;
    }

    public function setRequestFilter($filter)
    {
        $this->addBody('filter', $filter);
        return $this;
    }

    public function getResponseItems()
    {
        return Arr::get($this->httpJson, 'data.items');
    }

    public function getResponsePage()
    {
        return Arr::get($this->httpJson, 'data.page');
    }

    public function getResponsePageSize()
    {
        return Arr::get($this->httpJson, 'data.pageSize');
    }

    public function getResponseTotalPage()
    {
        return Arr::get($this->httpJson, 'data.totalPage');
    }

    public function getResponseTotal()
    {
        return Arr::get($this->httpJson, 'data.total');
    }
}
