<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = config('users');

        foreach ($users as $user) {
            $new_user = new User();
            $new_user->name = $user['name'];
            $new_user->lastname = $user['lastname'];
            $new_user->date_of_birth = $user['date_of_birth'];
            $new_user->email = $user['email'];
            $new_user->password = Hash::make($user['password']);            $new_user->save();
        }
    }
}
