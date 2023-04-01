<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployees extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'integer',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'type_user_id' => [
                'type' => 'integer',
                'constraint' => 2,
                'unsigned' => true,
                'null' => false
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 220,
                'null' => false
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => 100,
                'unique' => true
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'default' => null
            ],
            'is_active' => [
                'type' => 'boolean',
                'null' => false,
                'default' => false
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
            ->addForeignKey('type_user_id', 'type_users', 'id', 'cascade')
            ->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}
