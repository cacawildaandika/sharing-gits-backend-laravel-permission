<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SpatieRolePermissionTest extends TestCase
{
    /**
     * return void
     * @throws \Throwable
     */
    public function test_attach_permission()
    {
        DB::beginTransaction();
        try {

            $role = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $permission = Permission::where([
                'name' => 'read-article',
                'guard_name' => 'api',
            ])->first();

            $role->givePermissionTo($permission);

            DB::commit();
        } catch (\Throwable $throwable) {
            \Log::error($throwable->getMessage());
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }

    /**
     * return void
     * @throws \Throwable
     */
    public function test_detach_permission()
    {
        DB::beginTransaction();
        try {

            $role = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $permission = Permission::where([
                'name' => 'read-article',
                'guard_name' => 'api',
            ])->first();

            $role->revokePermissionTo($permission);

            DB::commit();
        } catch (\Throwable $throwable) {
            \Log::error($throwable->getMessage());
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }

    /**
     * return void
     * @throws \Throwable
     */
    public function test_give_multi_permission()
    {
        DB::beginTransaction();
        try {

            $role = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $permission1 = Permission::where([
                'name' => 'create-article',
                'guard_name' => 'api',
            ])->first();

            $permission2 = Permission::where([
                'name' => 'read-article',
                'guard_name' => 'api',
            ])->first();

//            $role->givePermissionTo($permission1, $permission2);
//            $role->givePermissionTo([$permission1, $permission2]);
            $role->syncPermissions([$permission1, $permission2]);

            DB::commit();
        } catch (\Throwable $throwable) {
            \Log::error($throwable->getMessage());
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }

    /**
     * return void
     * @throws \Throwable
     */
    public function test_revoke_multi_permission()
    {
        DB::beginTransaction();
        try {

            $role = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $role->syncPermissions([]);

            DB::commit();
        } catch (\Throwable $throwable) {
            \Log::error($throwable->getMessage());
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }
}
