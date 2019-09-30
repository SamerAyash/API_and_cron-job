<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Post;
use \App\comment;
use \Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
       /* for ($i=0; $i<50 ; $i++){
            $faker =\Faker\Factory::create();
            $user =  User::create([
                'name'=>$faker->name,
                'email'=>$faker->email,
                'password'=>Hash::make('12345678')
            ]);
            $user->save();
        }*/

    /*    for ($i=0; $i<100 ; $i++){

            $faker =\Faker\Factory::create();
            $post =  Post::create([
                'title'=>$faker->title,
                'details'=>$faker->streetAddress,
                'user_id'=>User::inRandomOrder()->first()['id'],
            ]);
            $post->save();
        }*/

         /*for ($i=0; $i<100 ; $i++){
            $faker =\Faker\Factory::create();
            $comment =  comment::create([
                'comment'=>$faker->text,
                'post_id'=>Post::inRandomOrder()->first()['id'],
                'user_id'=>User::inRandomOrder()->first()['id'],
            ]);
            $comment->save();
        }*/

    }
}
