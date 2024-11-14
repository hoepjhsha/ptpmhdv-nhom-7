<?php

namespace Auth\Controllers;

use Auth\Libraries\AuthLib;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    public function loginView(): ResponseInterface|string
    {
        if (session()->get('user')) {
            return $this->response->redirect('/');
        }
        $data = [
            'csrf_field' => csrf_field(),
            'title'      => 'Login',
            'error'      => session()->get('error'),
            'success'    => session()->get('success'),
        ];
        session()->remove('error');
        session()->remove('success');

        return $this->render('login', $data);
    }

    public function loginAction(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $form           = new AuthLib();
            $form->username = $this->request->getPost('username');
            $form->password = $this->request->getPost('password');

            if ($form->login()) {
                return $this->response->redirect('/');
            }
            session()->set('error', 'Invalid username or password');
        }

        return $this->response->redirect('login');
    }

    public function logoutAction(): ResponseInterface
    {
        session()->remove('user');

        return $this->response->redirect('/auth/login');
    }
}
