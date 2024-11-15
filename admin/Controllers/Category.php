<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 15/11/2024
 * @time 19:30
 */

namespace Admin\Controllers;

use Admin\Libraries\CatLib;
use CodeIgniter\HTTP\ResponseInterface;

class Category extends BaseController
{
    public function index(): string
    {
        return $this->render('dashboard-categories', [
            'title'      => 'Categories',
            'user'       => ucfirst(session()->get('user')['name']),
            'categories' => (new CatLib())->getCategoriesFromAPI(),
        ]);
    }

    public function create(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $category_name_create = $this->request->getPost('category_name');
            $form                 = new CatLib();
            if ($category_name_create) {
                $data = [
                    'category_name' => $category_name_create,
                ];
                if ($form->createCategory($data)) {
                    session()->setFlashdata('success', 'Created successfully!');
                } else {
                    session()->setFlashdata('error', 'Created failed!');
                }

                return $this->response->redirect('/admin/categories');
            }
        }

        return $this->response->redirect('/admin/categories');
    }

    public function edit($id): \CodeIgniter\HTTP\RedirectResponse|string
    {
        $catLib   = new CatLib();
        $category = $catLib->getCategoryById($id);

        if (! $category) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found');
        }

        return $this->render('edit-category', [
            'title'    => 'Edit Category',
            'user'     => ucfirst(session()->get('user')['name']),
            'category' => $category,
        ]);
    }

    public function update(mixed $id): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $category_name_update = $this->request->getPost('update_category_name');
            $form                 = new CatLib();
            if ($category_name_update) {
                $data = [
                    'category_name' => $category_name_update,
                ];
                if ($form->updateCategory($id, $data)) {
                    session()->setFlashdata('success', 'Updated successfully!');
                } else {
                    session()->setFlashdata('error', 'Updated failed!');
                }

                return $this->response->redirect('/admin/categories');
            }
        }

        return $this->response->redirect('/admin/categories');
    }

    public function deleteView($id): string
    {
        $catLib   = new CatLib();
        $category = $catLib->getCategoryById($id);

        return $this->render('delete-category', [
            'title'    => 'Delete Category',
            'user'     => ucfirst(session()->get('user')['name']),
            'category' => $category,
        ]);
    }

    public function delete($id): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $form = new CatLib();
            if ($form->deleteCategory($id)) {
                session()->setFlashdata('success', 'Deleted successfully!');
            } else {
                session()->setFlashdata('error', 'Deleted failed!');
            }

            return $this->response->redirect('/admin/categories');
        }

        return $this->response->redirect('/admin/categories');
    }
}
