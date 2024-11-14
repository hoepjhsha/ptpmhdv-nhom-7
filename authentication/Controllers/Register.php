<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 13/11/2024
 * @time 22:15
 */

namespace Auth\Controllers;

use Auth\Libraries\AuthLib;
use ReflectionException;

class Register extends BaseController
{
    public function registerView(): \CodeIgniter\HTTP\ResponseInterface|string
    {
        if (session()->get('user')) {
            return $this->response->redirect('/');
        }
        $data = [
            'csrf_field' => csrf_field(),
            'title'      => 'Register',
            'error'      => session()->get('error'),
            'success'    => session()->get('success'),
        ];
        session()->remove('error');
        session()->remove('success');

        return $this->render('register', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function registerAction(): \CodeIgniter\HTTP\ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $form           = new AuthLib();
            $form->username = $this->request->getPost('username');
            $form->password = $this->request->getPost('password');

            if ($form->register()) {
                return $this->response->redirect('/auth/register');
            }
        }

        return $this->response->redirect('/auth/register');
    }
}
