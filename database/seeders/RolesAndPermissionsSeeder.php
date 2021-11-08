<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create initial permissions

        $admin = [
            'access users',
            'create users',
            'edit users',
            'deactivate users',
            'access cashin',
            'approve cashin',
            'decline cashin',
            'access cashout',
            'approve cashout',
            'decline cashout',
            'access diamond conversion',
            'approve diamond conversion',
            'decline diamond conversion',
            'access products',
            'create products',
            'edit products',
            'archive products',
            'access reports',
            'access all networks'
        ];

        $team_leader = [
            'access cashin',
            'request cashin',
            'approve cashin',
            'decline cashin',
            'access cashout',
            'request cashout',
            'approve cashout',
            'decline cashout',
            'access diamond conversion',
            'request diamond conversion',
            'approve diamond conversion',
            'decline diamond conversion',
            'access own network',
            'access discounts',
            'order products'
        ];

        $member = [
            'request cashin',
            'request cashout',
            'request diamond conversion',
            'access discounts',
            'access own network',
            'order products'
        ];

        $observer = [
            'order products'
        ];

        $permissions = array_merge($admin, $team_leader, $observer, $member);
        foreach($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['name' => $permission]);
        }

        $systemadminRole            = Role::create(['name' => 'system administrator']);
        $managerRole                = Role::create(['name' => 'manager']);
        $teamleaderRole             = Role::create(['name' => 'team leader']);
        $observerRole               = Role::create(['name' => 'observer']);
        $memberRole                 = Role::create(['name' => 'member']);

        $systemadminRole->givePermissionTo($admin);
        $teamleaderRole->givePermissionTo($team_leader);
        $managerRole->givePermissionTo($team_leader);
        $observerRole->givePermissionTo($observer);
        $memberRole->givePermissionTo($member);

    }
}
