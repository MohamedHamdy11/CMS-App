<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::where('email', "admin@admin.com")->first();
        // $user = DB::table('users')->where('email', 'admin@admin.com')->first();
        User::create([
            'name'  => 'Mohamed',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role'  => 'admin'
        ]);
        User::create([
            'name'  => 'Mohamed user',
            'email' => 'user@user.com',
            'password' => Hash::make('123456')
        ]);

    }
} // end of UserTableSeeder
