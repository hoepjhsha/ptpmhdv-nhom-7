<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 13/11/2024
 * @time 23:37
 */

namespace Auth\Libraries;

use App\Libraries\PermissionException;
use Auth\Models\AccountModel;

class Authorization
{
    protected AccountModel $accountModel;
    protected array $user;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->user         = session()->get('loggedInUser') ?? [];
    }

    /**
     * Check if the user is logged in or not
     */
    public function checkLogin(): bool
    {
        if (empty($this->user)) {
            throw PermissionException::forUnauthorized();
        }

        return true;
    }

    /**
     * Check permissions based on a role (flag)
     */
    public function hasRole(int $role): bool
    {
        $this->checkLogin();

        if ($this->user['flag'] !== $role) {
            throw PermissionException::forUnauthorized();
        }

        return true;
    }

    /**
     * Check permissions based on a list of roles (flags)
     */
    public function inRoles(array $roles): bool
    {
        $this->checkLogin();

        if (! in_array($this->user['flag'], $roles, true)) {
            throw PermissionException::forUnauthorized();
        }

        return true;
    }

    /**
     * Check access based on status
     */
    public function isActive(): bool
    {
        $this->checkLogin();

        if ($this->user['status'] !== AccountModel::STATUS_ACTIVE) {
            throw PermissionException::forUnauthorized();
        }

        return true;
    }
}
