<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeSdkService extends Command
{
    protected $signature = 'make:sdkService  {name} {serviceName}';

    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->argument('name');
        $serviceName = $this->argument('serviceName');
        $studlyName = Str::studly($name);
        $kebabName = Str::kebab($name);
        $studlyServiceName = Str::studly($serviceName);
        $kebabServiceName = Str::kebab($serviceName);
        $fields = call_user_func([app('App\\Models\\' . $studlyName), 'getFillable']);
        $fields = array_unique($fields);
        $this->call('sdk:service', [
            'name' => $studlyServiceName . '/' . $studlyName . '/' . $studlyName . 'GetService',
            '--type' => 'get',
            '--serviceName' => $kebabServiceName,
            '--pathName' => $kebabName,
        ]);
        $this->call('sdk:service', [
            'name' => $studlyServiceName . '/' . $studlyName . '/' . $studlyName . 'CreateService',
            '--type' => 'create',
            '--serviceName' => $kebabServiceName,
            '--pathName' => $kebabName,
            '--request' => implode(',', $fields),
            '--response' => implode(',', $fields),
        ]);
        $this->call('sdk:service', [
            'name' => $studlyServiceName . '/' . $studlyName . '/' . $studlyName . 'UpdateService',
            '--type' => 'update',
            '--serviceName' => $kebabServiceName,
            '--pathName' => $kebabName,
            '--request' => implode(',', $fields),
            '--response' => implode(',', $fields),
        ]);
        $this->call('sdk:service', [
            'name' => $studlyServiceName . '/' . $studlyName . '/' . $studlyName . 'DetailService',
            '--type' => 'detail',
            '--serviceName' => $kebabServiceName,
            '--pathName' => $kebabName,
            '--response' => implode(',', $fields),
        ]);
        $this->call('sdk:service', [
            'name' => $studlyServiceName . '/' . $studlyName . '/' . $studlyName . 'DeleteService',
            '--type' => 'delete',
            '--serviceName' => $kebabServiceName,
            '--pathName' => $kebabName,
        ]);
    }
}
