<?php

namespace Client\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCategories extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('categories');
    }

    public function down()
    {
    }
}
