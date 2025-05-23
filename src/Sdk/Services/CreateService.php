<?php

namespace App\Sdk\Services;

class CreateService extends Service
{
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
