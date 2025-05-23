<?php

namespace App\Cores\Features;

use App\Cores\Core;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class Feature extends Core
{
    public function run()
    {
        DB::beginTransaction();;
        try {
            parent::run();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->exception($exception);
        }
        return $this;
    }

    final protected function camel($array)
    {
        $results = [];
        foreach ($array as $key => $value) {
            $camelKey = Str::camel($key);
            if (is_array($value) && !empty($value)) {
                $results[$camelKey] = $this->camel($value);
            } else {
                $results[$camelKey] = $value;
            }
        }
        return $results;
    }

    protected function exception(Exception $exception)
    {
        $this->error($exception->getMessage());
    }

    abstract protected function error($message = 'error', $data = []);
}
