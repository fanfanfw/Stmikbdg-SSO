<?php

namespace App\Models;

use App\Models\MyWebService;

class UserService extends MyWebService
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function getMyProfile()
    {
        return $this->get(null, '/me');
    }
}
