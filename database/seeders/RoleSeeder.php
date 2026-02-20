<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create([
            'name'=>'Adnim',
            'description'=>'This is an administrator'
        ]);
        Role::create([
            'name'=>'Trainer',
            'description'=>'This is a trainer'
        ]);Role::create([
            'name'=>'User',
            'description'=>'This is a user'
        ]);Role::create([
            'name'=>'Staff',
            'description'=>'This is a staff'
        ]);
    
    }
}
