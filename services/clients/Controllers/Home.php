<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 11:31
 */

namespace Client\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $itemsList = $this->getItemsList();
        return $this->render('shop', [
            'items' => $itemsList,
            'title' => 'Shop',
            'user'  => ucfirst(session()->get('user')['name']),
        ]);
    }

    private function getItemsList(): array
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

        // Khởi tạo CURL để lấy dữ liệu categories
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

        $dataItems      = json_decode($responseItems, true);
        $dataCategories = json_decode($responseCategories, true);

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
