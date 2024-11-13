<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'pmhdv',
        ];

        return $this->render('welcome_message', $data);
    }
}
