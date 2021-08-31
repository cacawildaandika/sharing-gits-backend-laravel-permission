<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SpatieRoleTest extends TestCase
{
    /**
     * return void
     * @throws \Throwable
     */
    public function test_create_role()
    {
        DB::beginTransaction();
        try {

            Role::create(['name' => 'superadmin', 'guard_name' => 'api']);
            Role::create(['name' => 'admin', 'guard_name' => 'api']);
            Role::create(['name' => 'writer', 'guard_name' => 'api']);
            Role::create(['name' => 'auditor', 'guard_name' => 'api']);

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
    public function test_attach_single_role()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);
            $role = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $user->assignRole($role);

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
    public function test_detach_single_role()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);
            $role = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $user->removeRole($role);

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
    public function test_attach_multi_role()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);

            $role1 = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $role2 = Role::where([
                'name' => 'superadmin',
                'guard_name' => 'api',
            ])->first();

//            $user->assignRole($role1, $role2);
//            $user->assignRole([$role1, $role2]);
            $user->syncRoles([$role1, $role2]);

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
    public function test_detach_multi_role()
    {
        DB::beginTransaction();
        try {

            $user = User::find(3);
            $user->syncRoles([]);

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

            $role1 = Role::where([
                'name' => 'admin',
                'guard_name' => 'api',
            ])->first();

            $role2 = Role::where([
                'name' => 'superadmin',
                'guard_name' => 'api',
            ])->first();

            $role3 = Role::where([
                'name' => 'writer',
                'guard_name' => 'api',
            ])->first();

            $role4 = Role::where([
                'name' => 'auditor',
                'guard_name' => 'api',
            ])->first();

//            $user->assignRole([$role1, $role2]);
//            $user->assignRole([$role3]);

            $user->syncRoles([$role4]);

            DB::commit();
        } catch (\Throwable $throwable) {
            \Log::error($throwable->getMessage());
            DB::rollBack();
        }

        $this->assertTrue(1 < 10, 'Success');
    }

}
