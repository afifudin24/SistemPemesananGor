<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'type' => 1,
                'password' => bcrypt('12345'),
                'alamat' => 'Alamat Admin',

            ],
            [
                'name' => 'Ibu Ajang',
                'email' => 'user@gmail.com',
                'type' => 0,
                'password' => bcrypt('12345'),
                'alamat' => 'Kalimantan',

            ],
            [
                'name' => 'Pemilik',
                'email' => 'pemilik@gmail.com',
                'type' => 2,
                'password' => bcrypt('12345'),
                'alamat' => 'Gor Garnish',

            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
