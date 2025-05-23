<?php

namespace App\Sdk\Services;

use Exception;

class DeleteService extends Service
{
    protected $id;

    protected $method = 'delete';

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
}
