<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentinelUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->delete();

        // $userUser = Sentry::getUserProvider()->findByLogin('user@user.com');
        $userUser = Sentinel::findByCredentials(['login' => 'user@user.com']);
        // $adminUser = Sentry::getUserProvider()->findByLogin('admin@admin.com');
        $adminUser = Sentinel::findByCredentials(['login' => 'admin@admin.com']);

        // $userRole = Sentry::getGroupProvider()->findByName('Users');
        $userRole = Sentinel::findRoleByName('Users');
        // $adminRole = Sentry::getGroupProvider()->findByName('Admins');
        $adminRole = Sentinel::findRoleByName('Admins');

        // Assign the roles to the users
        $userRole->users()->attach($userUser);
        $adminRole->users()->attach($adminUser);


        $this->command->info('Users assigned to roles seeded!');
    }
}
