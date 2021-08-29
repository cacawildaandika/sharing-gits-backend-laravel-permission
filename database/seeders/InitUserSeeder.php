<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class InitUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = str_replace('_', ' ', env('USER_NAME'));
        $user->email = env('USER_EMAIL');
        $user->password = \Hash::make(env('USER_PASSWORD'));
        $user->save();
    }
}
