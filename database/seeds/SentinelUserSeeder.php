<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentinelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Sentinel::create([
            'email'    => 'user@user.com',
            'password' => 'sentryuser',
            'first_name' => 'UserFirstName',
            'last_name' => 'UserLastName',
        ]);

        Sentinel::create([
            'email'    => 'admin@admin.com',
            'password' => 'sentryadmin',
            'first_name' => 'AdminFirstName',
            'last_name' => 'AdminLastName',
        ]);

        $this->command->info('Users seeded!');

    }
}
