<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = \Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'admin' => true
            ]
        ]);

        $user = \Sentinel::registerAndActivate([
            'email'   => 'admin@admin.com',
            'password'  =>  'password',
            'permissions' =>  [
                'admin' => true,
                'admin.user' => true,
                'admin.supplier' => true,
                'admin.item' => true,
                'admin.expense' => true,
                'admin.client' => true,
                'admin.purchase' => true,
                'admin.sales' => true,
            ]
        ]);

        $role = \Sentinel::findRoleByName('Admin');
        $role->users()->attach($user);

        $user2 = \Sentinel::registerAndActivate([
            'email' => 'forddyce92@gmail.com',
            'password' =>  'macpassword',
            'permissions' =>  [
                'admin' => true,
                'admin.user' => true,
                'admin.supplier' => true,
                'admin.item' => true,
                'admin.expense' => true,
                'admin.client' => true,
                'admin.purchase' => true,
                'admin.sales' => true,
            ]
        ]);
        
        $role->users()->attach($user2);
    }
}
