<?php

namespace Auth\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAccounts extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'unique'     => true,
                'constraint' => 255,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'flag' => [
                'type'    => 'SMALLINT',
                'default' => 2,
                'comment' => '0: root, 1: admin, 2: user',
            ],
            'status' => [
                'type'    => 'SMALLINT',
                'default' => 1,
                'comment' => '0: inactive, 1: active',
            ],
            'fail_time' => [
                'type'    => 'SMALLINT',
                'default' => 0,
            ],
            'last_login_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('accounts', true);
    }

    public function down()
    {
    }
}
