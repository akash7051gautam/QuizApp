<?php

use App\User;
use App\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(Admin::class)->create(['email'=>'admin@gmail.com']);
        //Role::create(['name'=>'Admin']);

        //$user->assignRole('Admin');
    }
}
