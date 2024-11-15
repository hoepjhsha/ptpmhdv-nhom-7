<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 15/11/2024
 * @time 14:51
 */

namespace Admin\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return $this->render('dashboard-index', [
            'title' => 'Dashboard',
            'user'  => ucfirst(session()->get('user')['name']),
        ]);
    }
}
