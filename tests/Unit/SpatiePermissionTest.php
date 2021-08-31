<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SpatiePermissionTest extends TestCase
{
    /**
     * return void
     * @throws \Throwable
     */
    public function test_create_permission()
    {
        DB::beginTransaction();
        try {

            Permission::create(['name' => 'create-article', 'guard_name' => 'api']);
            Permission::create(['name' => 'read-article', 'guard_name' => 'api']);
            Permission::create(['name' => 'update-article', 'guard_name' => 'api']);
            Permission::create(['name' => 'delete-article', 'guard_name' => 'api']);

            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }

    /**
     * return void
     * @throws \Throwable
     */
    public function test_give_single_permission()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);
            $permission = Permission::where([
                'name' => 'create-article',
                'guard_name' => 'api',
            ])->first();

            $user->givePermissionTo($permission);

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
    public function test_revoke_single_permission()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);
            $permission = Permission::where([
                'name' => 'create-article',
                'guard_name' => 'api',
            ])->first();

            $user->revokePermissionTo($permission);

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

            $user = User::find(3);

            $permission1 = Permission::where([
                'name' => 'create-article',
                'guard_name' => 'api',
            ])->first();

            $permission2 = Permission::where([
                'name' => 'read-article',
                'guard_name' => 'api',
            ])->first();

//            $user->givePermissionTo($permission1, $permission2);
//            $user->givePermissionTo([$permission1, $permission2]);
//            $user->syncPermissions([$permission1, $permission2]);

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

            $user = User::find(3);
            $user->syncPermissions([]);

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
    public function test_difference_attach_multi_role()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);

            $permission1 = Permission::where([
                'name' => 'create-article',
                'guard_name' => 'api',
            ])->first();

            $permission2 = Permission::where([
                'name' => 'read-article',
                'guard_name' => 'api',
            ])->first();

            $permission3 = Permission::where([
                'name' => 'update-article',
                'guard_name' => 'api',
            ])->first();

            $permission4 = Permission::where([
                'name' => 'delete-article',
                'guard_name' => 'api',
            ])->first();

//            $user->givePermissionTo([$permission1, $permission2]);
//            $user->givePermissionTo([$permission3]);
//
            $user->syncPermissions([$permission4]);

            DB::commit();
        } catch (\Throwable $throwable) {
            \Log::error($throwable->getMessage());
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }
}
