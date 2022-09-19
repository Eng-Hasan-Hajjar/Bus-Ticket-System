<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('posts')->truncate();

        DB::table('posts')->insert(
            [
                'title' => 'title goes here'
            ]
        );

        $this->call('DatabaseSeeder');
    }
}
