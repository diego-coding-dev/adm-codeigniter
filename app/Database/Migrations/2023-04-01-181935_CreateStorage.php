<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStorage extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'integer',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'product_id' => [
                'type' => 'integer',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false
            ],
            'quantity' => [
                'type' => 'integer',
                'contraint' => 3,
                'unsigned' => true,
                'null' => false
            ],
            'price' => [
                'type' => 'decimal',
                'constraint' => '8,2',
                'unsigned' => true,
                'null' => true,
                'default' => null
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
            ->addForeignKey('product_id', 'products', 'id', 'cascade')
            ->createTable('storages');
    }

    public function down()
    {
        $this->forge->dropTable('storages');
    }
}
