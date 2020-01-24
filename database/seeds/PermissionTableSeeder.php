<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name' => 'role-read',
                'display_name' => 'Display Role Listing',
                'description' => 'See only Listing of Role'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create Role',
                'description' => 'Create new Role'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Edit Role',
                'description' => 'Edit Role'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete Role',
                'description' => 'Delete Role'
            ],
            [
                'name' => 'incident-list',
                'display_name' => 'Display Incidents',
                'description' => 'See Incidents'
            ],
            [
                'name' => 'incident-create',
                'display_name' => 'Create Incident',
                'description' => 'Create New Incident'
            ],
            [
                'name' => 'incident-update',
                'display_name' => 'Update Incident',
                'description' => 'Update Incident'
            ],
            [
                'name' => 'incident-delete',
                'display_name' => 'Delete Incident',
                'description' => 'Delete Incident'
            ],
            [
                'name' => 'incident-dispatch',
                'display_name' => 'Dispatch Incident',
                'description' => 'Dispatch Incident to Unit'
            ]

        ];

        foreach($permission as $key=> $value)
        {
            Permission::create($value);
        }
    }
}
