<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AddDefaultData extends Seeder
{
    public function run(): void
    {
        $filePath = STORAGE_PATH . 'Resources/UV_Product2.xlsx';

        $spreadsheet = IOFactory::load($filePath);
        $worksheet   = $spreadsheet->getActiveSheet();

        $data  = [];
        $first = true;

        foreach ($worksheet->getRowIterator() as $row) {
            if ($first) {
                $first = false;

                continue;
            }

            $rowData = [];

            $rowData[] = $worksheet->getCell('B' . $row->getRowIndex())->getValue();
            $rowData[] = $worksheet->getCell('C' . $row->getRowIndex())->getValue();
            $rowData[] = $worksheet->getCell('J' . $row->getRowIndex())->getValue();
            $rowData[] = $worksheet->getCell('E' . $row->getRowIndex())->getValue();
            $rowData[] = $worksheet->getCell('R' . $row->getRowIndex())->getValue();
            $rowData[] = $worksheet->getCell('S' . $row->getRowIndex())->getValue();

            $data[] = $rowData;
        }

        foreach ($data as $row) {
            if (in_array(null, $row, true)) {
                continue;
            }

            $this->db->table('items')->insert([
                'item_code'        => $row[0],
                'item_name'        => $row[1],
                'item_price'       => $row[2],
                'item_category_id' => $row[3],
                'item_image'       => $row[4],
                'item_description' => $row[5],
            ]);
        }

        $dataCat = [];
        $first   = true;

        foreach ($worksheet->getRowIterator() as $row) {
            if ($first) {
                $first = false;

                continue;
            }

            $rowData = [];

            $columnE = $worksheet->getCell('E' . $row->getRowIndex())->getValue();
            $columnD = $worksheet->getCell('D' . $row->getRowIndex())->getValue();

            if ($columnE === 2) {
                continue;
            }

            $existing = array_column($dataCat, 0);

            if (! in_array($columnE, $existing, true)) {
                $rowData[] = $columnE;
                $rowData[] = $columnD;
                $dataCat[] = $rowData;
            }
        }

        foreach ($dataCat as $row) {
            if (in_array(null, $row, true)) {
                continue;
            }

            $this->db->table('categories')->insert([
                'id'            => $row[0],
                'category_name' => $row[1],
            ]);
        }

        $this->db->table('categories')->delete(['id' => 2]);
    }
}
