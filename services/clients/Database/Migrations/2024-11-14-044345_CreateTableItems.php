<?php

namespace Client\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableItems extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'item_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
                'null'       => false,
            ],
            'item_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'item_price' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'item_category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'item_image' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'item_description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('item_category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('items');
    }

    public function down()
    {
    }
}
