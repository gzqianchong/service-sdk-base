<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CoreUnit extends GeneratorCommand
{
    protected $name = 'core:unit';

    protected $description = 'Create a new unit class';

    protected $type = 'Unit';

    protected function getStub()
    {
        if ($this->option('type')) {
            return $this->resolveStubPath('/stubs/core.unit.' . $this->option('type') . '.stub');
        }
        return $this->resolveStubPath('/stubs/core.unit.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Cores\Units';
    }

    protected function getOptions()
    {
        return [
            ['request', 'request', InputOption::VALUE_OPTIONAL, 'request'],
            ['response', 'response', InputOption::VALUE_OPTIONAL, 'response'],
            ['modelName', 'modelName', InputOption::VALUE_OPTIONAL, 'modelName'],
            ['type', 'type', InputOption::VALUE_OPTIONAL, 'type'],
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
                $requestMethod .= str_pad('', 8) . '$this->setRequest(\'' . $camelRequest . '\', $' . $camelRequest . ');' . PHP_EOL;
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
                $responseMethod .= str_pad('', 8) . 'return $this->getResponse(\'' . $camelResponse . '\');' . PHP_EOL;
                $responseMethod .= str_pad('', 4) . '}' . PHP_EOL;
            }
        }
        $stub = str_replace(['{{ responseMethod }}'], rtrim($responseMethod, PHP_EOL), $stub);
        $stub = str_replace(['{{ modelName }}'], $this->option('modelName'), $stub);
        return parent::replaceClass($stub, $name);
    }
}
