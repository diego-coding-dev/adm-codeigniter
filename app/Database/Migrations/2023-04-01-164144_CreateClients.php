<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClients extends Migration
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
            ->createTable('clients');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}
