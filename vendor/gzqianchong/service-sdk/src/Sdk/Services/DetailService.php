<?php

namespace App\Sdk\Services;

use Exception;

class DetailService extends Service
{
    protected $id;

    protected $method = 'get';

    /**
     * @throws Exception
     */
    protected function request()
    {
        parent::request();
        if (empty($this->id)) {
            throw new Exception('id不能为空');
        }
        $this->path = $this->path . '/' . $this->id;
    }

    public function setRequestId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getResponseId()
    {
        return $this->getResponseData('id');
    }

    public function getResponseCreateAt()
    {
        return $this->getResponseData('createAt');
    }

    public function getResponseUpdateAt()
    {
        return $this->getResponseData('updateAt');
    }

    public function getResponseDeleteAt()
    {
        return $this->getResponseData('deleteAt');
    }
}
