<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'make:module {modelName?} {moduleName?}';

    protected $description = 'Command description';

    public function handle()
    {
        $this->units();
        $this->features();
        $this->controller();
    }

    protected function units()
    {
        $modelName = $this->argument('modelName');
        if (empty($modelName)) {
            return;
        }
        $modelName = Str::studly($modelName);
        $fields = call_user_func([app('App\\Models\\' . $modelName), 'getFillable']);
        $fields = array_unique($fields);
        $ids = ['id'];
        $times = ['createAt', 'updatedAt', 'deleteAt'];
        $this->call('core:unit', [
            'name' => $modelName . '/' . $modelName . 'CreateUnit',
            '--request' => implode(',', $fields),
            '--response' => implode(',', array_merge($ids, $fields, $times)),
            '--type' => 'create',
            '--modelName' => $modelName,
        ]);
        $this->call('core:unit', [
            'name' => $modelName . '/' . $modelName . 'UpdateUnit',
            '--request' => implode(',', array_merge($ids, $fields, $times)),
            '--response' => implode(',', $fields),
            '--type' => 'update',
            '--modelName' => $modelName,
        ]);
        $this->call('core:unit', [
            'name' => $modelName . '/' . $modelName . 'DeleteUnit',
            '--request' => implode(',', $ids),
            '--response' => implode(',', array_merge($ids, $fields, $times)),
            '--type' => 'delete',
            '--modelName' => $modelName,
        ]);
    }

    protected function features()
    {
        $modelName = $this->argument('modelName');
        if (empty($modelName)) {
            return;
        }
        $modelName = Str::studly($modelName);
        $moduleName = $this->argument('moduleName');
        if (empty($moduleName)) {
            return;
        }
        $moduleName = Str::studly($moduleName);
        $this->call('core:feature', [
            'name' => $moduleName . '/' . $modelName . '/' . $modelName . 'IndexFeature',
            '--type' => 'index',
            '--modelName' => $modelName,
            '--moduleName' => $moduleName,
        ]);
        $this->call('core:feature', [
            'name' => $moduleName . '/' . $modelName . '/' . $modelName . 'StoreFeature',
            '--type' => 'store',
            '--modelName' => $modelName,
            '--moduleName' => $moduleName,
        ]);
        $this->call('core:feature', [
            'name' => $moduleName . '/' . $modelName . '/' . $modelName . 'UpdateFeature',
            '--type' => 'update',
            '--modelName' => $modelName,
            '--moduleName' => $moduleName,
        ]);
        $this->call('core:feature', [
            'name' => $moduleName . '/' . $modelName . '/' . $modelName . 'DestroyFeature',
            '--type' => 'destroy',
            '--modelName' => $modelName,
            '--moduleName' => $moduleName,
        ]);
        $this->call('core:feature', [
            'name' => $moduleName . '/' . $modelName . '/' . $modelName . 'ShowFeature',
            '--type' => 'show',
            '--modelName' => $modelName,
            '--moduleName' => $moduleName,
        ]);
    }

    protected function controller()
    {
        $modelName = $this->argument('modelName');
        if (empty($modelName)) {
            return;
        }
        $modelName = Str::studly($modelName);
        $moduleName = $this->argument('moduleName');
        if (empty($moduleName)) {
            return;
        }
        $moduleName = Str::studly($moduleName);
        $this->call('make:controller', [
            'name' => $moduleName . '/' . $modelName . 'Controller',
            '--type' => 'api',
            '--modelName' => $modelName,
            '--moduleName' => $moduleName,
        ]);
    }
}
