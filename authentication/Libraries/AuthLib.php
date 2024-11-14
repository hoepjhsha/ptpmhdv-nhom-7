<?php

namespace Auth\Libraries;

use Auth\Models\AccountModel;
use ReflectionException;

class AuthLib extends AccountModel
{
    public string $username;
    public string $password;

    /**
     * @throws ReflectionException
     */
    public function login(): bool
    {
        $user = $this->where('username', $this->username)->first();
        if ($user) {
            if (password_verify($this->password, $user->password)) {
                if ($user->status === self::STATUS_ACTIVE) {
                    $session = session();
                    $session->set([
                        'user' => [
                            'id'        => $user->id,
                            'name'      => $user->username,
                            'flag'      => $user->flag,
                            'flag_name' => self::FLAGS[$user->flag],
                        ],
                    ]);

                    $data = [
                        'last_login_at' => date('Y-m-d H:i:s', time()),
                    ];

                    return $this->update($user->id, $data);
                }

                return false;
            }

            return false;
        }

        return false;
    }

    /**
     * @throws ReflectionException
     */
    public function register(): bool
    {
        $user = $this->where('username', $this->username)->first();
        if (! $user) {
            $data = [
                'username'      => $this->username,
                'password'      => password_hash($this->password, PASSWORD_BCRYPT),
                'flag'          => 2,
                'status'        => 1,
                'fail_time'     => 0,
                'last_login_at' => null,
                'created_at'    => date('Y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time()),
            ];

            if ($this->insert($data, false)) {
                session()->set('success', 'Registration successful');

                return true;
            }
            session()->set('error', 'Failed to register');
        } else {
            session()->set('error', 'Username already registered');
        }

        return false;
    }
}
