<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeProducts extends Migration
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
            'type_product' => [
                'type' => 'varchar',
                'constraint' => 30,
                'unsigned' => true,
                'null' => false
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
            ->createTable('type_products');
    }

    public function down()
    {
        $this->forge->dropTable('type_products');
    }
}
