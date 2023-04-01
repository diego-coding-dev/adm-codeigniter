<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
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
            'client_id' => [
                'type' => 'integer',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false
            ],
            'employee_id' => [
                'type' => 'integer',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false
            ],
            'register' => [
                'type' => 'varchar',
                'contraint' => 11,
                'null' => false
            ],
            'total' => [
                'type' => 'decimal',
                'constraint' => '8,2',
                'unsigned' => true,
                'null' => false
            ],
            'is_settled' => [
                'type' => 'boolean',
                'null' => false,
                'default' => false
            ],
            'is_canceled' => [
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
            ->addForeignKey('client_id', 'clients', 'id', 'cascade')
            ->addForeignKey('employee_id', 'employees', 'id', 'cascade')
            ->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
