<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public $user;
    public $role;

    public function __construct(\App\Models\User $user, \App\Models\Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $su = $this->user->newQuery()->where("email","super@admin.com")->first();
        if($su != null){
            $suRole = $this->role->newQuery()->where("name","super-user")->first();
            if($suRole != null){
                $su->attachRole($suRole);
            }
        }

        $admin = $this->user->newQuery()->where("email","admin@admin.com")->first();
        if($admin != null){
            $adminRole = $this->role->newQuery()->where("name","admin")->first();
            if($adminRole != null){
                $admin->attachRole($adminRole);
            }
        }
    }
}
