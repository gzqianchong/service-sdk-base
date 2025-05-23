<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class SdkService extends GeneratorCommand
{
    protected $name = 'sdk:service';

    protected $description = 'Create a new service class';

    protected $type = 'Service';

    protected function getStub()
    {
        if ($this->option('type')) {
            return $this->resolveStubPath('/stubs/sdk.service.' . $this->option('type') . '.stub');
        }
        return $this->resolveStubPath('/stubs/sdk.service.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'App\Sdk\Services';
    }

    protected function getOptions()
    {
        return [
            ['serviceName', 'serviceName', InputOption::VALUE_OPTIONAL, 'serviceName'],
            ['pathName', 'pathName', InputOption::VALUE_OPTIONAL, 'pathName'],
            ['type', 'type', InputOption::VALUE_OPTIONAL, 'type'],
            ['request', 'request', InputOption::VALUE_OPTIONAL, 'request'],
            ['response', 'response', InputOption::VALUE_OPTIONAL, 'response'],
        ];
    }

    public function replaceClass($stub, $name)
    {
        // request
        $requestMethod = '';
        $request = $this->option('request');
        if ($request) {
            $requestMethod .= PHP_EOL;
            $requests = explode(',', $request);
            foreach ($requests as $request) {
                $camelRequest = Str::camel($request);
                $studlyRequest = Str::studly($request);
                $requestMethod .= PHP_EOL;
                $requestMethod .= str_pad('', 4) . 'public function setRequest' . $studlyRequest . '($' . $camelRequest . ')' . PHP_EOL;
                $requestMethod .= str_pad('', 4) . '{' . PHP_EOL;
                $requestMethod .= str_pad('', 8) . '$this->addBody(\'' . $camelRequest . '\', $' . $camelRequest . ');' . PHP_EOL;
                $requestMethod .= str_pad('', 8) . 'return $this;' . PHP_EOL;
                $requestMethod .= str_pad('', 4) . '}' . PHP_EOL;
            }
        }
        $stub = str_replace(['{{ requestMethod }}'], rtrim($requestMethod, PHP_EOL), $stub);
        // response
        $responseMethod = '';
        $response = $this->option('response');
        if (!empty($response)) {
            $responseMethod .= PHP_EOL;
            $responses = explode(',', $response);
            foreach ($responses as $response) {
                $camelResponse = Str::camel($response);
                $studlyResponse = Str::studly($response);
                $responseMethod .= PHP_EOL;
                $responseMethod .= str_pad('', 4) . 'public function getResponse' . $studlyResponse . '()' . PHP_EOL;
                $responseMethod .= str_pad('', 4) . '{' . PHP_EOL;
                $responseMethod .= str_pad('', 8) . 'return $this->getResponseData(\'' . $camelResponse . '\');' . PHP_EOL;
                $responseMethod .= str_pad('', 4) . '}' . PHP_EOL;
            }
        }
        $stub = str_replace(['{{ responseMethod }}'], rtrim($responseMethod, PHP_EOL), $stub);

        $stub = str_replace(['{{ serviceName }}'], $this->option('serviceName'), $stub);
        $stub = str_replace(['{{ pathName }}'], $this->option('pathName'), $stub);
        return parent::replaceClass($stub, $name);
    }
}
