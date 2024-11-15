<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 15:21
 */

namespace Api\Controllers;

class Item extends RestControllers
{
    protected $modelName = 'Storage\Models\ItemModel';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (! $data) {
            return $this->failNotFound('Item not found');
        }
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if (! $this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondCreated($data, 'Item created');
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if (! $this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondUpdated($data, 'Item updated');
    }

    public function delete($id = null)
    {
        if (! $this->model->delete($id)) {
            return $this->failNotFound('Item not found');
        }
        return $this->respondDeleted('Item deleted');
    }
}
