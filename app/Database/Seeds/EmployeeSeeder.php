<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employeeModel = new Employee();

        $employee = [
            'type_user_id' => 2,
            'name' => 'funcionario 1',
            'email' => 'funcionario1@mail.com',
            'password' => password_hash('radeonhd4850', PASSWORD_DEFAULT),
            'is_active' => true
        ];


        $employeeModel->skipValidation(true)->insert($employee);
    }
}
