<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $usersData = [
            collect([
                'first_name' => config('app.seeders.super_admin.first_name'),
                'last_name' => config('app.seeders.super_admin.last_name'),
                'username' => 'superadmin',
                'email' => config('app.seeders.super_admin.email'),
                'password' => Hash::make(config('app.seeders.super_admin.password')),
                'roles' => ['super-admin']
            ]),
            collect([
                'first_name' => config('app.seeders.admin.first_name'),
                'last_name' => config('app.seeders.admin.last_name'),
                'username' => 'admin',
                'email' => config('app.seeders.admin.email'),
                'password' => Hash::make(config('app.seeders.admin.password')),
                'roles' => ['admin']
            ]),
            collect([
                'first_name' => config('app.seeders.developer.first_name'),
                'last_name' => config('app.seeders.developer.last_name'),
                'username' => 'user_dev_' . Str::random(8),
                'email' => config('app.seeders.developer.email'),
                'password' => Hash::make(config('app.seeders.developer.password')),
                'roles' => ['developer']
            ]),
        ];

        foreach ($usersData as $userData) {
            $data = $userData->only('email')->toArray();
            $updateData = $userData->except('email', 'roles')->toArray();

            $user = User::updateOrCreate($data, $updateData);
            $user->syncRoles($userData->only('roles')->toArray());
        }

    }
}
