<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderCarts extends Migration
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
            'order_id' => [
                'type' => 'integer',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false
            ],
            'storage_id' => [
                'type' => 'integer',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false
            ],
            'quantity' => [
                'type' => 'integer',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false
            ],
            'is_finished' => [
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
            ->addForeignKey('order_id', 'orders', 'id', 'cascade')
            ->addForeignKey('storage_id', 'storages', 'id', 'cascade')
            ->createTable('order_carts');
    }

    public function down()
    {
        $this->forge->dropTable('order_carts');
    }
}
