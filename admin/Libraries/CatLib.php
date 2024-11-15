<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 15/11/2024
 * @time 16:25
 */

namespace Admin\Libraries;

use Storage\Models\CategoryModel;

class CatLib extends CategoryModel
{
    /**
     * Create a new category
     */
    public function createCategory(array $data): array|bool
    {
        $db  = \Config\Database::connect();
        $sql = 'INSERT INTO categories (category_name) VALUES (?)';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$data['category_name']]);

        return (bool) $query;
    }

    /**
     * Update an existing category
     */
    public function updateCategory(int $id, array $data): array|bool
    {
        $db  = \Config\Database::connect();
        $sql = 'UPDATE categories SET category_name = ? WHERE id = ?';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$data['category_name'], $id]);

        return (bool) $query;
    }

    /**
     * Delete a category by ID
     */
    public function deleteCategory(int $id): bool|\CodeIgniter\Database\BaseResult
    {
        $db  = \Config\Database::connect();
        $sql = 'DELETE FROM categories WHERE id = ?';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$id]);

        return (bool) $query;
    }

    public function getCategoryByID($userId): array|object|null
    {
        return $this->where('id', $userId)->first();
    }

    public function getCategoriesFromAPI(): array
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'http://pmhdv.local/api/categories',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Cookie: csrf_cookie_name=21267f59add8c27433cda5f47902ee40',
            ],
        ]);
        $responseCategories = curl_exec($curl);
        curl_close($curl);

        $dataCategories = json_decode($responseCategories, true);

        return $dataCategories ?? [];
    }
}
