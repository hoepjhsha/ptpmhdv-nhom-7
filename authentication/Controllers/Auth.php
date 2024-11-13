<?php

namespace Auth\Controllers;

use App\Controllers\BaseController;
use Auth\Libraries\AuthLib;
use CodeIgniter\HTTP\ResponseInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Auth extends BaseController
{
    protected string $module_name = 'Auth';

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(): ResponseInterface|string
    {
        if (session()->get('user')) {
            return $this->response->redirect('/');
        }
        if ($this->request->getMethod() === 'POST') {
            $form           = new AuthLib();
            $form->username = $this->request->getVar('username');
            $form->password = $this->request->getVar('password');

            if ($form->login()) {
                return $this->response->redirect('/');
            }
        }

        $csrf_token = csrf_token();
        $csrf_hash  = csrf_hash();

        return $this->twig->renderView('pages-login.html.twig', [
            'csrf_token' => $csrf_token,
            'csrf_hash'  => $csrf_hash,
        ]);
    }

    public function logout(): ResponseInterface
    {
        $session = session();
        $session->destroy();

        return $this->response->redirect('/auth/login');
    }
}
