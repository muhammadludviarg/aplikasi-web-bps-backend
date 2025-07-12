<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* User::create([ 
            'name' => 'Admin', 
            'email' => 'admin@example.com', 
            'password' => Hash::make('password') 
        ]); */
        /* User::create([ 
            'name' => 'Argorahayu', 
            'email' => 'pbw@gmail.com', 
            'password' => Hash::make('2ks3') 
        ]); */
        User::create([ 
            'name' => 'stis', 
            'email' => 'stis@example.com', 
            'password' => Hash::make('setis') 
        ]);
    }
}
