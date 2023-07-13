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
        for($i=0; $i<15; $i++) {
            $new_user = new User();
            $new_user->name = $faker->firstname();
            $new_user->lastname = $faker->lastname();
            $new_user->date_of_birth = $faker->date('Y-m-d');
            // $new_user->email = $faker->email();
            $new_user->email = strtolower($new_user->lastname) . '@gmail.com';
            $new_user->password = Hash::make('12345678');
            // dump($new_user);
            $new_user->save();
        }
    }
}
