<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = new Profile();
        $adminRole = Role::whereName('Admin')->first();
        $studentRole = Role::whereName('Student')->first();
        $dosenRole = Role::whereName('Dosen')->first();

        // Seed test admin
        $seededAdminEmail = 'admin@admin.com';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Admin',
                'first_name'                     => 'Harry',
                'last_name'                      => 'Potter',
                'email'                          => $seededAdminEmail,
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_confirmation_ip_address' => '127.0.0.1',
                'admin_ip_address'               => '127.0.0.1',
            ]);

            $user->profile()->save($profile);
            $user->attachRole($adminRole);
            $user->save();
        }

        // Seed test user
        $user = User::where('email', '=', 'student_demo@larakkn.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Student 1',
                'first_name'                     => 'Student',
                'last_name'                      => 'Demo 1',
                'email'                          => 'student_demo1@larakkn.com',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => '127.0.0.1',
                'signup_confirmation_ip_address' => '127.0.0.1',
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($studentRole);
            $user->save();
        }
        $user = User::where('email', '=', 'student_demo@larakkn.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Student 2',
                'first_name'                     => 'Student',
                'last_name'                      => 'Demo 2',
                'email'                          => 'student_demo2@larakkn.com',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => '127.0.0.1',
                'signup_confirmation_ip_address' => '127.0.0.1',
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($studentRole);
            $user->save();
        }
        $user = User::where('email', '=', 'student_demo@larakkn.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Student 3',
                'first_name'                     => 'Student',
                'last_name'                      => 'Demo 3',
                'email'                          => 'student_demo3@larakkn.com',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => '127.0.0.1',
                'signup_confirmation_ip_address' => '127.0.0.1',
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($studentRole);
            $user->save();
        }
        $user = User::where('email', '=', 'dosen_demo@larakkn.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Dosen 1',
                'first_name'                     => 'Dosen',
                'last_name'                      => 'Demo 1',
                'email'                          => 'dosen_demo1@larakkn.com',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => '127.0.0.1',
                'signup_confirmation_ip_address' => '127.0.0.1',
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($dosenRole);
            $user->save();
        }
        $user = User::where('email', '=', 'dosen_demo@larakkn.com')->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'Dosen 2',
                'first_name'                     => 'Dosen',
                'last_name'                      => 'Demo 2',
                'email'                          => 'dosen_demo2@larakkn.com',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => '127.0.0.1',
                'signup_confirmation_ip_address' => '127.0.0.1',
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($dosenRole);
            $user->save();
        }

        // Seed test users
        // $user = factory(App\Models\Profile::class, 5)->create();
        // $users = User::All();
        // foreach ($users as $user) {
        //     if (!($user->isAdmin()) && !($user->isUnverified())) {
        //         $user->attachRole($userRole);
        //     }
        // }
    }
}