<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 16/11/2024
 * @time 01:30
 */

namespace Admin\Libraries;

use Storage\Models\ItemModel;

class ItemLib extends ItemModel
{
    /**
     * Create a new category
     */
    public function createItem(array $data): array|bool
    {
        $db  = \Config\Database::connect();
        $sql = 'INSERT INTO items (item_code, item_name, item_price, item_category_id, item_image, item_description) VALUES (?, ?, ?, ?, ?, ?)';

        $query = $db->query($sql, ['a', $data['name'], $data['price'], $data['category_id'], $data['image'], 'a']);

        return (bool) $query;
    }

    /**
     * Update an existing category
     */
    public function updateItem(int $id, array $data): array|bool
    {
        $db  = \Config\Database::connect();
        $sql = 'UPDATE items SET item_name = ?, item_price = ?, item_category_id = ?, item_image = ? WHERE id = ?';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$data['name'], $data['price'], $data['category_id'], $data['image'], $id]);

        return (bool) $query;
    }

    /**
     * Delete a category by ID
     */
    public function deleteItem(int $id): bool|\CodeIgniter\Database\BaseResult
    {
        $db  = \Config\Database::connect();
        $sql = 'DELETE FROM items WHERE id = ?';

        // Sử dụng prepare statement
        $query = $db->query($sql, [$id]);

        return (bool) $query;
    }

    public function getItemByID($userId): array|object|null
    {
        return $this->where('id', $userId)->first();
    }

    public function getItemsFromAPI(): array
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'http://pmhdv.local/api/items',
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
        $responseItems = curl_exec($curl);
        curl_close($curl);

        $dataItems      = json_decode($responseItems, true);
        $dataCategories = (new CatLib())->getCategoriesFromAPI();

        $categoryMap = [];

        foreach ($dataCategories as $category) {
            $categoryMap[$category['id']] = $category['category_name'];
        }

        $itemsList = [];

        foreach ($dataItems as $item) {
            $itemsList[] = [
                'id'          => $item['id'],
                'name'        => $item['item_name'],
                'price'       => $item['item_price'],
                'image'       => $item['item_image'],
                'description' => $item['item_description'],
                'category'    => $categoryMap[$item['item_category_id']] ?? 'Unknown',
            ];
        }

        return $itemsList;
    }
}
