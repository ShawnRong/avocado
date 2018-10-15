<?php

namespace ShawnRong\Avocado\Database;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminUser();
    }

    /**
     * Create super admin
     * @return void
     */
    private function createAdminUser()
    {
        AdminUser::query()->truncate();
        AdminUser::query()->create([
            'name' => config('avocado.super_admin.name'),
            'email' => config('avocado.super_admin.email'),
            'password' => config('avocado.super_admin.password'),
        ]);
    }
}
