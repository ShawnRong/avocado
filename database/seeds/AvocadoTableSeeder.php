<?php

namespace


use Illuminate\Database\Seeder;
use ShawnRong\Avocado\Models\AdminUser;
use ShawnRong\Avocado\Models\Permission;
use ShawnRong\Avocado\Models\PermissionGroup;
use Spatie\Permission\Models\Role;

class AvocadoTableSeeder extends Seeder
{

    private $permissions = [
        [
            'name'         => 'admin-user.index',
            'display_name' => 'index',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'admin-user.show',
            'display_name' => 'show',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'admin-user.store',
            'display_name' => 'store',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'admin-user.update',
            'display_name' => 'update',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'admin-user.destroy',
            'display_name' => 'destroy',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'admin-user.roles',
            'display_name' => 'role list',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'admin-user.assign-roles',
            'display_name' => 'assign role',
            'pg_id'        => 1,
        ],
        [
            'name'         => 'role.index',
            'display_name' => 'index',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.show',
            'display_name' => 'show',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.store',
            'display_name' => 'store',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.update',
            'display_name' => 'update',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.destroy',
            'display_name' => 'destroy',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.permissions',
            'display_name' => 'role permissions',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.assign-permissions',
            'display_name' => 'role assignment authority',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'role.guard-name-roles',
            'display_name' => 'Specify the role of guard name',
            'pg_id'        => 2,
        ],
        [
            'name'         => 'permission.index',
            'display_name' => 'index',
            'pg_id'        => 3,
        ],
        [
            'name'         => 'permission.show',
            'display_name' => 'show',
            'pg_id'        => 3,
        ],
        [
            'name'         => 'permission.store',
            'display_name' => 'store',
            'pg_id'        => 3,
        ],
        [
            'name'         => 'permission.update',
            'display_name' => 'update',
            'pg_id'        => 3,
        ],
        [
            'name'         => 'permission.destroy',
            'display_name' => 'destroy',
            'pg_id'        => 3,
        ],
        [
            'name'         => 'permission.all-user-permission',
            'display_name' => 'All permissions of the user',
            'pg_id'        => 3,
        ],
        [
            'name'         => 'menu.index',
            'display_name' => 'index',
            'pg_id'        => 4,
        ],
        [
            'name'         => 'menu.my',
            'display_name' => 'My menu',
            'pg_id'        => 4,
        ],
        [
            'name'         => 'menu.show',
            'display_name' => 'show',
            'pg_id'        => 4,
        ],
        [
            'name'         => 'menu.store',
            'display_name' => 'store',
            'pg_id'        => 4,
        ],
        [
            'name'         => 'menu.update',
            'display_name' => 'update',
            'pg_id'        => 4,
        ],
        [
            'name'         => 'menu.destroy',
            'display_name' => 'destroy',
            'pg_id'        => 4,
        ],
        [
            'name'         => 'permission-group.index',
            'display_name' => 'index',
            'pg_id'        => 5,
        ],
        [
            'name'         => 'permission-group.show',
            'display_name' => 'show',
            'pg_id'        => 5,
        ],
        [
            'name'         => 'permission-group.store',
            'display_name' => 'store',
            'pg_id'        => 5,
        ],
        [
            'name'         => 'permission-group.update',
            'display_name' => 'update',
            'pg_id'        => 5,
        ],
        [
            'name'         => 'permission-group.destroy',
            'display_name' => 'destroy',
            'pg_id'        => 5,
        ],
        [
            'name'         => 'permission-group.guard-name-for-permission',
            'display_name' => 'Guard name for permissions',
            'pg_id'        => 5,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminUser();
        $this->createPermission();
        $this->createPermissionGroup();
        $this->createRole();
        $this->associateRolePermission();
    }

    /**
     * Create super admin
     *
     * @return void
     */
    private function createAdminUser()
    {
        AdminUser::query()->truncate();
        AdminUser::query()->create([
            'name'     => config('avocado.super_admin.name'),
            'email'    => config('avocado.super_admin.email'),
            'password' => bcrypt(config('avocado.super_admin.password')),
        ]);
    }

    private function createPermission()
    {
        Permission::query()->delete();

        foreach ($this->permissions as $permission) {
            $permission['guard_name'] = config('avocado.super_admin.guard');
            Permission::create($permission);
        }
    }

    private function createPermissionGroup()
    {
        PermissionGroup::truncate();
        PermissionGroup::insert([
            [
                'id'   => 1,
                'name' => 'Admin users',
            ],
            [
                'id'   => 2,
                'name' => 'Role',
            ],
            [
                'id'   => 3,
                'name' => 'Permission',
            ],
            [
                'id'   => 4,
                'name' => 'Menu',
            ],
            [
                'id'   => 5,
                'name' => 'Permission groups',
            ],
        ]);
    }

    private function createRole()
    {
        Role::query()->delete();
        Role::create([
            'name'       => 'admin',
            'guard_name' => config('avocado.super_admin.guard'),
        ]);
    }

    private function associateRolePermission()
    {
        $role = Role::first();
        AdminUser::query()->first()->assignRole($role->name);
        foreach ($this->permissions as $permission) {
            $role->givePermissionTo($permission['name']);
        }
    }
}
