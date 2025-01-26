<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User::create([
        //     'name'      => 'John',
        //     'lastname'  => 'Doe',
        //     'email'     => 'johndoe@example.com',
        //     'password'  => bcrypt('password'),
        //     'roles'     => ['user'],
        //     'isActive'  => true,
        //     'tel'       => '123456789',
        // ]);
        User::create([
            'name'      => 'Luca',
            'lastname'  => 'Rojas Massey',
            'email'     => 'lucasrojas95@dev.com.ar',
            'password'  => bcrypt('Luca123456'),
            'roles'     => ['ADMIN'],
            'image'     => 'https://drive.google.com/file/d/1t4GWcUI2A4dkzuIDkIQHbMABuapdNAZY/view?usp=sharing',
            'isActive'  => true,
            'tel'       => '+54 9 1131728677',
        ]);
    }
}
