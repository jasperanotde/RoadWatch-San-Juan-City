<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateNormalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Zyre Mendoza', 
            'email' => 'mendozazyre@gmail.com',
            'password' => bcrypt('password')
        ]);
        
        $role = Role::create(['name' => 'Normal User']);
         
        // Find the necessary permissions
        $permissions = Permission::whereIn('name', [
            'report-list',
            'report-create',
            'report-edit',
            'report-delete',
        ])->get();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}
