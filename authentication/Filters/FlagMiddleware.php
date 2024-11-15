<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 13/11/2024
 * @time 23:21
 */

namespace Auth\Filters;

use App\Libraries\PermissionException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FlagMiddleware implements FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function before(RequestInterface $request, $arguments = null): void
    {
        // TODO: Implement before() method.
        $user = session()->get('user');
        if ($user && $user['flag'] == 2) {
            throw PermissionException::forUnauthorized();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}
