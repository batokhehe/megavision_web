<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->call('ClientSeeder');
        $this->call('EmployeeSeeder');
        $this->call('ItemSeeder');
        $this->call('OfficeSeeder');
        $this->call('OrderSeeder');
        $this->call('UserSeeder');
    }
}
