<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'aldmic',
            'email' => 'aldmic@mail.com',
            'password' => Hash::make('123abc123'), // Hash the password
        ]);
    }
}
