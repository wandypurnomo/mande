<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("roles")->insert([
            [
                "name" => "super-admin",
                "display_name" => "Super Admin",
                "description" => "Super Admin Role"
            ],

            [
                "name" => "admin",
                "display_name" => "Admin",
                "description" => "Admin Role"
            ],

            [
                "name" => "user",
                "display_name" => "User",
                "description" => "User Role"
            ],
        ]);
    }
}
