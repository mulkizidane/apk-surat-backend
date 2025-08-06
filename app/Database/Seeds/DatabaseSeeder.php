<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UnitSeeder');
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
    }
}
