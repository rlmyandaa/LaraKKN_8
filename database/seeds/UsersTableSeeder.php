<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $dosenRole = config('roles.models.role')::where('name', '=', 'Dosen')->first();
        $studentRole = config('roles.models.role')::where('name', '=', 'Student')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'student_demo@larakkn.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Student',
                'email'    => 'student_demo@larakkn.com',
                'password' => bcrypt('password'),
            ]);

            $newUser;
            $newUser->attachRole($studentRole);
        }
        if (config('roles.models.defaultUser')::where('email', '=', 'dosen_demo@larakkn.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Dosen',
                'email'    => 'dosen_demo@larakkn.com',
                'password' => bcrypt('password'),
            ]);

            $newUser;
            $newUser->attachRole($dosenRole);
        }
    }
}
