<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'integer',
                'constraint' => 2,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'type_user' => [
                'type' => 'varchar',
                'constraint' => 100
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ]
        ])
            ->addPrimaryKey('id')
            ->createTable('type_users');
    }

    public function down()
    {
        $this->forge->dropTable('type_users');
    }
}
