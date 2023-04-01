<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivationTokens extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'email' => [
                'type' => 'varchar',
                'null' => false,
                'unique' => true
            ],
            'token_hash' => [
                'type' => 'varchar',
                'constraint' => 255,
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
            ->addPrimaryKey('email')
            ->createTable('activation_tokens');
    }

    public function down()
    {
        $this->forge->dropTable('activation_tokens');
    }
}
