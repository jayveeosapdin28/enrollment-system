<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SuperAdministrator' => [
                'access user',
                'insert user',
                'edit user',
                'update user',
                'delete user',
                'view user',

                'access student-info',
                'insert student-info',
                'edit student-info',
                'update student-info',
                'delete student-info',
                'view student-info',

                'access contact',
                'insert contact',
                'edit contact',
                'update contact',
                'delete contact',
                'view contact',

                'access subject',
                'insert subject',
                'edit subject',
                'update subject',
                'delete subject',
                'view subject',
            ],
            'Admin' => [
                'access user',
                'insert user',
                'edit user',
                'update user',
                'delete user',
                'view user',

                'access student-info',
                'insert student-info',
                'edit student-info',
                'update student-info',
                'delete student-info',
                'view student-info',

                'access contact',
                'insert contact',
                'edit contact',
                'update contact',
                'delete contact',
                'view contact',

                'access subject',
                'insert subject',
                'edit subject',
                'update subject',
                'delete subject',
                'view subject',

                'access assessment',
                'insert assessment',
                'edit assessment',
                'update assessment',
                'delete assessment',
                'view assessment',

                'access registration',
                'insert registration',
                'edit registration',
                'update registration',
                'delete registration',
                'view registration',

                'access dashboard',
                'insert dashboard',
                'edit dashboard',
                'update dashboard',
                'delete dashboard',
                'view dashboard',
            ],
            'Student' => [
                'insert user',

                'access student-info',
                'insert student-info',
                'edit student-info',
                'update student-info',
                'delete student-info',
                'view student-info',

                'access contact-info',
                'insert contact-info',
                'edit contact-info',
                'update contact-info',
                'delete contact-info',
                'view contact-info',
            ],

            'Accounting' => [
                'access assessment',
                'insert assessment',
                'edit assessment',
                'update assessment',
                'delete assessment',
                'view assessment',

                'access fee',
                'insert fee',
                'edit fee',
                'update fee',
                'delete fee',
                'view fee',

                'access dashboard',
                'insert dashboard',
                'edit dashboard',
                'update dashboard',
                'delete dashboard',
                'view dashboard',
            ],
            'Registrar' => [
                'access registration',
                'insert registration',
                'edit registration',
                'update registration',
                'delete registration',
                'view registration',

                'access dashboard',
                'insert dashboard',
                'edit dashboard',
                'update dashboard',
                'delete dashboard',
                'view dashboard',
            ],
            'Clinic' => [
                'access medical-record',
                'insert medical-record',
                'edit medical-record',
                'update medical-record',
                'delete medical-record',
                'view medical-record',

                'view registration',

                'access student-info',
                'view student-info',
            ],

        ];

        foreach ($roles as $role => $permissions) {
            $db_role = Role::where('name', $role)->first();
            if (!$db_role) {
                // CREATE NEW ROLE
                $db_role = Role::create(['name' => $role]);
            }
            // ADD PERMISSION
            foreach ($permissions as  $permission) {
                $new_permission = Permission::where('name', $permission)->first();
                if (!$new_permission) {
                    $new_permission = Permission::create([
                        'name' => $permission
                    ]);
                }
            }
            $db_role->syncPermissions($permissions);
        }
        // ASSIGN SUPER ADMIN ROLE
        $user = User::findOrFail(1);
        $user->assignRole('SuperAdministrator'); // SUPER ADMIN
    }
}
