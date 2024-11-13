<?php

namespace Auth\Entities;

use CodeIgniter\Entity\Entity;

class Account extends Entity
{
    protected $attributes = [
        'id'            => null,
        'username'      => null,
        'password'      => null,
        'flag'          => null,
        'status'        => null,
        'fail_time'     => null,
        'last_login_at' => null,
        'created_at'    => null,
        'updated_at'    => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'last_login_at'];
    protected $casts = [
        'id'        => 'int',
        'flag'      => 'int',
        'fail_time' => 'int',
        'status'    => 'int',
    ];
}
