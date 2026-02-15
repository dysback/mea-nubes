<?php

namespace Dysback\NubesMea\Api\Management;

use Dysback\Ogo\Controller\BaseController;

class Users extends BaseController
{
    public function add(string $name, string $id)
    {
        return [
            'status' => 'success',
            'id' => $id,
            'name' => $name,
            'message' => 'User added successfully',
        ];
    }
}
