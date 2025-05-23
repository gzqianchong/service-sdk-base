<?php

namespace ServiceSdkBase\Services\Category;

use ServiceSdkBase\Services\GetService;

class CategoryGetService extends GetService
{
    protected $path = '/service-base/api/category';

    protected $method = 'get';
}
