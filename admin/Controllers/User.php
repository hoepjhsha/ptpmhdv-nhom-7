<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 16/11/2024
 * @time 03:20
 */

namespace Admin\Controllers;

use Admin\Libraries\UserLib;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class User extends BaseController
{
    public function index(): string
    {
        return $this->render('dashboard-users', [
            'title'    => 'Users',
            'user'     => ucfirst(session()->get('user')['name']),
            'accounts' => (new UserLib())->getAll(),
        ]);
    }

    public function createView(): string
    {
        return $this->render('create-user', [
            'title' => 'Users',
            'user'  => ucfirst(session()->get('user')['name']),
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function create(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $username = $this->request->getPost('create_username');
            $password = password_hash($this->request->getPost('create_password'), PASSWORD_DEFAULT);
            $flag     = $this->request->getPost('create_flag');
            if ((new UserLib())->createUser([
                'username'      => $username,
                'password'      => $password,
                'flag'          => $flag,
                'status'        => 1,
                'fail_time'     => 0,
                'last_login_at' => null,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ])) {
                session()->setFlashdata('success', 'Created successfully!');
            } else {
                session()->setFlashdata('error', 'Created failed!');
            }

            return redirect()->to(base_url('admin/users'));
        }

        return redirect()->to(base_url('admin/users'));
    }

    public function edit($id): string
    {
        $account = (new UserLib())->getUserById($id);

        return $this->render('edit-user', [
            'title'   => 'Users',
            'user'    => ucfirst(session()->get('user')['name']),
            'account' => $account,
        ]);
    }

    public function update(mixed $id): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $username  = $this->request->getPost('update_username');
            $password  = password_hash($this->request->getPost('update_password'), PASSWORD_DEFAULT);
            $flag      = $this->request->getPost('update_flag');
            $status    = $this->request->getPost('update_status');
            $fail_time = $this->request->getPost('update_fail_time');
            $form      = new UserLib();

            $data = [
                'username'   => $username,
                'password'   => $password,
                'flag'       => $flag,
                'status'     => $status,
                'fail_time'  => $fail_time,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if ($form->updateUser($id, $data)) {
                session()->setFlashdata('success', 'Updated successfully!');
            } else {
                session()->setFlashdata('error', 'Updated failed!');
            }

            return $this->response->redirect('/admin/users');
        }

        return $this->response->redirect('/admin/users');
    }

    public function deleteView($id): string
    {
        $account = (new UserLib())->getUserById($id);

        return $this->render('delete-user', [
            'title'   => 'Users',
            'user'    => ucfirst(session()->get('user')['name']),
            'account' => $account,
        ]);
    }

    public function delete($id): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $form = new UserLib();
            if ($form->deleteUser($id)) {
                session()->setFlashdata('success', 'Deleted successfully!');
            } else {
                session()->setFlashdata('error', 'Deleted failed!');
            }

            return $this->response->redirect('/admin/users');
        }

        return $this->response->redirect('/admin/users');
    }
}
