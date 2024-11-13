<?php

namespace Auth\Libraries;

use Auth\Models\AccountModel;

class AuthLib extends AccountModel
{
    public string $username;
    public string $password;

    public function login(): bool
    {
        $user = $this->where('username', $this->username)->first();
        if ($user) {
            $password = password_hash($this->password, PASSWORD_BCRYPT);
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

                    return true;
                }

                return false;
            }

            return false;
        }

        return false;
    }
}
