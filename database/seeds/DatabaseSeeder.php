<?php

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
        // $this->call(UsersTableSeeder::class);
                // MessagesTableSeeder の呼び出し
        $this->call([PostsTableSeeder::class]);

    }
}
