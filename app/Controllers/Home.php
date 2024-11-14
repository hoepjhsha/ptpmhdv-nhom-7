<?php

namespace App\Controllers;

use App\Libraries\PermissionException;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'pmhdv',
        ];

        //        throw PermissionException::forUnauthorized();

        return $this->render('welcome_message', $data);
    }
}
