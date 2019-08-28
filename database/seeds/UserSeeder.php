<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                "id" => \Ramsey\Uuid\Uuid::uuid4(),
                "name" => "SuperAdmin",
                "email" => "super@admin.com",
                "phone" => "000000000000",
                "email_verified_at"=>\Carbon\Carbon::now()->addYears(-10),
                "phone_verified_at" => \Carbon\Carbon::now()->addYears(-10),
                "password" => bcrypt("wandx54"),
                "created_at"=>\Carbon\Carbon::now()->addYears(-10),
                "updated_at" => \Carbon\Carbon::now()->addYears(-10),
            ],

            [
                "id" => \Ramsey\Uuid\Uuid::uuid4(),
                "name" => "Admin",
                "email" => "admin@admin.com",
                "phone" => "000000000001",
                "email_verified_at"=>\Carbon\Carbon::now()->addYears(-9),
                "phone_verified_at" => \Carbon\Carbon::now()->addYears(-9),
                "password" => bcrypt("password"),
                "created_at"=>\Carbon\Carbon::now()->addYears(-9),
                "updated_at" => \Carbon\Carbon::now()->addYears(-9),
            ]
        ]);
    }
}
