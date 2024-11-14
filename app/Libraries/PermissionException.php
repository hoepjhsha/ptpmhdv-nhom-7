<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 13/11/2024
 * @time 23:28
 */

namespace App\Libraries;

use CodeIgniter\Exceptions\FrameworkException;

class PermissionException extends FrameworkException
{
    public static function forUnauthorized(): self
    {
        return new self('You do not have the necessary permission to perform the desired operation.');
    }
}
