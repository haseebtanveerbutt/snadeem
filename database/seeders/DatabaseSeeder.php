<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user= new User();
        $user->id=1;
        $user->name="Admin";
        $user->email="admin@gmail.com";
        $user->role = 1;
        $user->password=bcrypt("123456");
        $user->save();
    }
}
