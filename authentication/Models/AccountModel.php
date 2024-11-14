<?php

namespace Auth\Models;

use Auth\Entities\Account;
use CodeIgniter\Model;

class AccountModel extends Model
{
    final public const int FLAG_ADMIN      = 0;
    final public const int FLAG_TEACHER    = 1;
    final public const int FLAG_STUDENT    = 2;
    final public const int STATUS_INACTIVE = 0;
    final public const int STATUS_ACTIVE   = 1;
    final public const int STATUS_DRAFT    = 2;
    final public const array FLAGS         = [
        '0' => 'Super Admin',
        '1' => 'Admin',
        '2' => 'User',
    ];

    protected $table         = 'accounts';
    protected $primaryKey    = 'id';
    protected $returnType    = Account::class;
    protected $allowedFields = [
        'username',
        'password',
        'flag',
        'status',
        'fail_time',
        'last_login_at',
        'created_at',
        'updated_at',
    ];
    protected $validationRules = [
        'username' => 'required|alpha_numeric',
        'password' => 'required',
        'flag'     => 'in_list[0,1,2]',
        'status'   => 'in_list[0,1]',
    ];
    protected $validationMessages = [
        'username' => [
            'required'      => 'Username is required.',
            'alpha_numeric' => 'Username must be alphanumeric.',
        ],
        'password' => [
            'required' => 'Password is required.',
        ],
        'flag' => [
            'in_list' => 'Invalid flag. It must be either 0 (admin) or 1 (user).',
        ],
        'status' => [
            'in_list' => 'Invalid status. It must be either 0 (inactive), 1 (active), or 2 (draft).',
        ],
    ];
    protected $useTimestamps = true;
}
