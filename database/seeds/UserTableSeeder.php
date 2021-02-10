<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'username' => 'Tony',
            'email'    => 'tony@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
