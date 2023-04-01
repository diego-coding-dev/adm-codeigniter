<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProducts extends Migration
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
            'type_product_id' => [
                'type' => 'integer',
                'constraint' => 2,
                'unsigned' => true,
                'null' => false
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => 150,
                'null' => false
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => 255,
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
            ->addForeignKey('type_product_id', 'type_products', 'id', 'cascade')
            ->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
