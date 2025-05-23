<?php

namespace App\Cores;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class Core
{
    protected $data = [];

    public function __construct()
    {
        $this->data = new Data();
    }

    public static function init()
    {
        return new static();
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function run()
    {
        try {
            $this->request();
            $this->execute();
            $this->response();
        } catch (Exception $exception) {
            Log::error(get_class($this) . 'core错误', [
                'error' => $exception->getMessage(),
                'data' => $this->data->all(),
            ]);
            throw $exception;
        }
        return $this;
    }

    abstract protected function execute();

    public function setRequests($requests)
    {
        foreach ($requests as $key => $request) {
            $this->setRequest($key, $request);
        }
        return $this;
    }

    protected function getRequests()
    {
        return $this->data->getItem('request');
    }

    public function setRequest($key, $value)
    {
        $this->data->setItem('request.' . $key, $value);
        return $this;
    }

    protected function getRequest($key, $default = null)
    {
        return $this->data->getItem('request.' . $key, $default);
    }

    protected function setResponses($responses)
    {
        foreach ($responses as $key => $response) {
            $this->setResponse($key, $response);
        }
        return $this;
    }

    public function getResponses()
    {
        return $this->data->getItem('response');
    }

    protected function setResponse($key, $value)
    {
        $this->data->setItem('response.' . $key, $value);
        return $this;
    }

    public function getResponse($key, $default = null)
    {
        return $this->data->getItem('response.' . $key, $default);
    }

    /**
     * @param $rules
     * @param array $messages
     * @throws Exception
     */
    public function validate($rules, $messages = [])
    {
        if (empty($rules)) {
            return;
        }
        $rules = $this->snake($rules);
        if (!empty($messages)) {
            $messages = $this->snake($messages);
            $messages = Arr::dot($messages);
        }
        $validate = Validator::make($this->data->all(), $rules, $messages);
        if ($validate->fails()) {
            throw new Exception($validate->errors()->first());
        }
    }

    final protected function snake($array)
    {
        $results = [];
        foreach ($array as $key => $value) {
            $camelKey = Str::snake($key);
            if (is_array($value) && !empty($value)) {
                $results[$camelKey] = $this->snake($value);
            } else {
                $results[$camelKey] = $value;
            }
        }
        return $results;
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

    protected function request()
    {

    }

    protected function response()
    {

    }
}
