<?php

namespace App\Sdk\Services;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Service
{
    public static function init()
    {
        return new static();
    }

    protected function request()
    {

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
            Log::error(get_class($this) . '请求错误', [
                'error' => $exception->getMessage(),
                'path' => $this->path,
                'body' => $this->body,
                'response' => $this->httpJson,
            ]);
            throw $exception;
        }
        return $this;
    }

    protected function response()
    {

    }

    protected $method = '';

    protected $path = '';

    protected $body = [];

    protected $httpJson = [];

    /**
     * @throws Exception
     */
    protected function execute()
    {
        $url = $this->getUrl();
        switch ($this->method) {
            case 'post':
                $http = Http::post($url, $this->body);
                break;
            case 'put':
                $http = Http::put($url, $this->body);
                break;
            case 'delete':
                $http = Http::delete($url, $this->body);
                break;
            default:
                $http = Http::get($url, $this->body);
                break;
        }
        $this->httpJson = $http->json();
    }

    /**
     * @throws Exception
     */
    protected function getUrl()
    {
        $host = 'https://' . config('app.env') . '-apigateway.qcyyds.com/service-base/api/';
        $path = $this->path;
        if (empty($path)) {
            throw new Exception('path不能为空');
        }
        return trim($host, '/') . '/' . trim($path, '/');
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    protected function addBody($key, $value)
    {
        $this->body = Arr::add($this->body, $key, $value);
        return $this;
    }

    /**
     * @param $organizationId
     * @return $this
     */
    public function setRequestOrganizationId($organizationId)
    {
        $this->addBody('organizationId', $organizationId);
        return $this;
    }

    public function isSuccess()
    {
        return Arr::get($this->httpJson, 'success');
    }

    public function getErrorMessage()
    {
        return Arr::get($this->httpJson, 'errorMessage');
    }

    protected function getResponseData($key)
    {
        return Arr::get($this->httpJson, 'data.' . $key);
    }
}
