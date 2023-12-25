<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $permissions = [
       'articles' =>  [
            'show article', 'create article','edit article', 'delete article', 
            'approve article', 'reject article','show others articles',
            'edit others articles','delete others articles', 'approve others articles',
            'reject others articles',
       ],
       'comments' => [
            'can comment','show comment','create comment', 'edit comment', 'delete comment',
            'approve comment', 'reject comment','show others comments','edit others comments',
            'delete others comments','approve others comments','reject others comments'
       ],
       'users' => [
            'show user','create user','edit user', 'delete user'
        ],
        'roles' => [
            'show role','create role','edit role', 'delete role','change user role'
        ],
    ];
    public function run(): void
    {

        $role = Role::create(['name' => 'super admin']);
        foreach ($this->permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::create([
                        'name' => $permission,
                        'guard_name' => 'web'
                    ]);
            }
        }

       $role->syncPermissions($this->permissions);
       $admin = \App\Models\User::where('email','osama.saieed@gmail.com')->first();
       if($admin) $admin->assignRole('super admin');

    }
}
