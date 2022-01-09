<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use \Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now();
        $user1 = [
            'name' => 'Zayn Rifky',
            'username'=> 'zaynrifky',
            'email'=> 'zaynrifky12333@gmail.com',
            'password' => \Hash::make('12345678'),
            'role' => 'chief',
            'created_at' => $timestamp
        ];
        
        $user2 = [
            'name' => 'Samanta Khodir',
            'username'=> 'samanta',
            'email'=> 'samanta@gmail.com',
            'password' => \Hash::make('12345678'),
            'role' => 'officer',
            'created_at' => $timestamp
        ];

        User::create($user1);
        User::create($user2);
    }
}
