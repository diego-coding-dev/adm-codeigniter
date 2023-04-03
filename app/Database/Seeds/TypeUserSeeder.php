<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeUserSeeder extends Seeder
{
    public function run()
    {
        $db = db_connect('default');

        $typeUsers = [
            'client',
            'employee'
        ];

        foreach ($typeUsers as $typeuser) {
            $db->table('type_users')->insert([
                'type_user' => $typeuser
            ]);
        }
    }
}
