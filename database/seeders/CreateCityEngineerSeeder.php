<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateCityEngineerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $user1 = User::create([
        'name' => 'Albert Nicholas', 
        'email' => 'albert@gmail.com',
        'contact_number' => '9498091321',
        'password' => bcrypt('password')
    ]);
    
    $user2 = User::create([
        'name' => 'Sigmund Pavlov', 
        'email' => 'sigmund@gmail.com',
        'contact_number' => '9498091322',
        'password' => bcrypt('password')
    ]);

    $role = Role::create(['name' => 'City Engineer']);

    $permissions = Permission::pluck('id', 'id')->all();

    $role->syncPermissions($permissions);

    $user1->assignRole([$role->id]);
    $user2->assignRole([$role->id]);
}
}
