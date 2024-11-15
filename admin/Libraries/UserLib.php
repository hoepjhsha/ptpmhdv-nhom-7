<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 16/11/2024
 * @time 03:24
 */

namespace Admin\Libraries;

use Auth\Models\AccountModel;
use ReflectionException;

class UserLib extends AccountModel
{
    public function getAll(): array
    {
        return $this->findAll();
    }

    /**
     * @throws ReflectionException
     */
    public function createUser(array $data): bool|int|string
    {
        return $this->insert($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        $db  = \Config\Database::connect();
        $sql = 'UPDATE accounts SET username = ?, password = ?, flag = ?, status = ?, fail_time = ?, updated_at = ? WHERE id = ?';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$data['username'], $data['password'], $data['flag'], $data['status'], $data['fail_time'], $data['updated_at'], $id]);

        return (bool) $query;
    }

    public function deleteUser(int $id): bool
    {
        $db  = \Config\Database::connect();
        $sql = 'DELETE FROM accounts WHERE id = ?';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$id]);

        return (bool) $query;
    }

    public function getUserById(int $id): object
    {
        return $this->where('id', $id)->first();
    }
}
