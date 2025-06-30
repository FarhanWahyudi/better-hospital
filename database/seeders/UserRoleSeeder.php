<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['manager', 'customer', 'doctor', 'patient', 'insurance'];
        $permissions = ['create role', 'edit role', 'delete role', 'view role'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissionTo($permissions);

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'name' => ucfirst($role) . ' user',
                'email' => $role . '@example.com',
                'phone' => fake()->phoneNumber(),
                'photo' => fake()->imageUrl(200, 200, 'people', true, 'profile'),
                'gender' => 'Male',
                'password' => Hash::make('password1234')
            ]);

            $user->assignRole($role);
        }
    }
}
