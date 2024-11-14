<?php

namespace Auth\Filters;

class AuthMiddleware implements \CodeIgniter\Filters\FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function before(\CodeIgniter\HTTP\RequestInterface $request, $arguments = null)
    {
        if (! session()->get('user')) {
            return response()->redirect('/auth/login');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function after(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}
