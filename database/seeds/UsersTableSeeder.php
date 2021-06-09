<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create(['email'=>'admin@gmail.com']);
        Permission::create(['name'=>'ManageUser']);
        Role::create(['name'=>'Admin'])->givePermissionTo('ManageUser');
        Role::create(['name'=>'Organization'])->givePermissionTo('ManageUser');;
        Role::create(['name'=>'User']);
        
        $user->assignRole(['Admin','Organization']);
    }
}
