<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'id' => 1,
            'slug' => 'admin',
            'name' => 'Admin'
        ]);

        Role::firstOrCreate([
            'id' => 2,
            'slug' => 'agency',
            'name' => 'Agency'
        ]);

        Role::firstOrCreate([
            'id' => 3,
            'slug' => 'tradesman',
            'name' => 'Tradesman'
        ]);

        Role::firstOrCreate([
            'id' => 4,
            'slug' => 'customer',
            'name' => 'Customer'
        ]);

        Role::firstOrCreate([
            'id' => 5,
            'slug' => 'agent',
            'name' => 'Agent'
        ]);

        Role::firstOrCreate([
            'id' => 6,
            'slug' => 'staff',
            'name' => 'Staff'
        ]);
    }
}
