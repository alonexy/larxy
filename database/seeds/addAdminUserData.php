<?php

use Illuminate\Database\Seeder;

class addAdminUserData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'alonexy',
            'email' => '961610358@qq.com',
            'password' => bcrypt('123321aa'),
            'status'=>1
        ]);
    }
}
