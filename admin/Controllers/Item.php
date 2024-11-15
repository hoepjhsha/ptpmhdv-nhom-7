<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 16/11/2024
 * @time 01:28
 */

namespace Admin\Controllers;

use Admin\Libraries\CatLib;
use Admin\Libraries\ItemLib;
use CodeIgniter\HTTP\ResponseInterface;

class Item extends BaseController
{
    public function index(): string
    {
        return $this->render('dashboard-items', [
            'title' => 'Items',
            'user'  => session()->get('user')['name'],
            'items' => (new ItemLib())->getItemsFromAPI(),
        ]);
    }

    public function createView(): string
    {
        return $this->render('create-item', [
            'title'      => 'Add new Item',
            'user'       => session()->get('user')['name'],
            'categories' => (new CatLib())->getCategoriesFromAPI(),
        ]);
    }

    public function create(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $name        = $this->request->getPost('create_name');
            $price       = $this->request->getPost('create_price');
            $category_id = $this->request->getPost('create_category');
            $image       = $this->request->getPost('create_image');
            $form        = new ItemLib();
            $data        = [
                'name'        => $name,
                'price'       => $price,
                'category_id' => $category_id,
                'image'       => $image,
            ];
            $form->createItem($data);

            return $this->response->redirect('/admin/items/create');
        }

        return $this->response->redirect('/admin/items/create');
    }

    public function edit($id): string
    {
        $lib  = new ItemLib();
        $item = $lib->getItemByID($id);

        $newItem = [
            'id'          => $id,
            'name'        => $item->item_name,
            'price'       => $item->item_price,
            'image'       => $item->item_image,
            'category_id' => $item->item_category_id,
        ];

        return $this->render('edit-item', [
            'title'      => 'Edit Item',
            'categories' => (new CatLib())->getCategoriesFromAPI(),
            'item'       => $newItem,
        ]);
    }

    public function update(mixed $id): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $name        = $this->request->getPost('update_name');
            $price       = $this->request->getPost('update_price');
            $category_id = $this->request->getPost('update_category');
            $image       = $this->request->getPost('update_image');
            $form        = new ItemLib();

            $data = [
                'name'        => $name,
                'price'       => $price,
                'category_id' => $category_id,
                'image'       => $image,
            ];
            $form->updateItem($id, $data);

            return $this->response->redirect('/admin/items/' . $id . '/edit');
        }

        return $this->response->redirect('/admin/items/' . $id . '/edit');
    }

    public function delete($id): ResponseInterface
    {
        if ($this->request->getMethod() === 'GET') {
            $form = new ItemLib();
            $form->deleteItem($id);

            return $this->response->redirect('/admin/items');
        }

        return $this->response->redirect('/admin/items');
    }
}
