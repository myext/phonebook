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
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Иван',
            'surname' => 'Иванов',
            'patronymic' => 'Иванович',
        ]);

        DB::table('phones')->insert([
            'id' => 1,
            'number' => 111111111111,
            'user_id' => 1,
            'is_mobile' => 1,
        ]);

        DB::table('phones')->insert([
            'id' => 2,
            'number' => 222222222222,
            'user_id' => 1,
            'is_mobile' => 0,
        ]);
    }
}
