<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
//            [
//                'id'    => 1,
//                'title' => 'user_management_access',
//            ],
//            [
//                'id'    => 2,
//                'title' => 'permission_create',
//            ],
//            [
//                'id'    => 3,
//                'title' => 'permission_edit',
//            ],
//            [
//                'id'    => 4,
//                'title' => 'permission_show',
//            ],
//            [
//                'id'    => 5,
//                'title' => 'permission_delete',
//            ],
//            [
//                'id'    => 6,
//                'title' => 'permission_access',
//            ],
//            [
//                'id'    => 7,
//                'title' => 'role_create',
//            ],
//            [
//                'id'    => 8,
//                'title' => 'role_edit',
//            ],
//            [
//                'id'    => 9,
//                'title' => 'role_show',
//            ],
//            [
//                'id'    => 10,
//                'title' => 'role_delete',
//            ],
//            [
//                'id'    => 11,
//                'title' => 'role_access',
//            ],
//            [
//                'id'    => 12,
//                'title' => 'user_create',
//            ],
//            [
//                'id'    => 13,
//                'title' => 'user_edit',
//            ],
//            [
//                'id'    => 14,
//                'title' => 'user_show',
//            ],
//            [
//                'id'    => 15,
//                'title' => 'user_delete',
//            ],
//            [
//                'id'    => 16,
//                'title' => 'user_access',
//            ],
//            [
//                'id'    => 17,
//                'title' => 'audit_log_show',
//            ],
//            [
//                'id'    => 18,
//                'title' => 'audit_log_access',
//            ],
//            [
//                'id'    => 19,
//                'title' => 'profile_password_edit',
//            ],
//            [
//                'id'    => 20,
//                'title' => 'setting_edit',
//            ],
//            [
//                'id'    => 21,
//                'title' => 'setting_access',
//            ],

            [
                'id'    => 22,
                'title' => 'faculty_delete',
            ],
            [
                'id'    => 23,
                'title' => 'faculty_access',
            ],
            [
                'id'    => 24,
                'title' => 'convocation_create',
            ],
            [
                'id'    => 25,
                'title' => 'convocation_edit',
            ],
            [
                'id'    => 26,
                'title' => 'convocation_show',
            ],
            [
                'id'    => 27,
                'title' => 'convocation_delete',
            ],
            [
                'id'    => 28,
                'title' => 'convocation_access',
            ],
            [
                'id'    => 29,
                'title' => 'program_create',
            ],
            [
                'id'    => 30,
                'title' => 'program_edit',
            ],
            [
                'id'    => 31,
                'title' => 'program_show',
            ],
            [
                'id'    => 32,
                'title' => 'program_delete',
            ],
            [
                'id'    => 33,
                'title' => 'program_access',
            ],
            [
                'id'    => 34,
                'title' => 'student_create',
            ],
            [
                'id'    => 35,
                'title' => 'student_edit',
            ],
            [
                'id'    => 36,
                'title' => 'student_show',
            ],
            [
                'id'    => 37,
                'title' => 'student_delete',
            ],
            [
                'id'    => 38,
                'title' => 'student_access',
            ],
            [
                'id'    => 39,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 40,
                'title' => 'faculty_create',
            ],
            [
                'id'    => 41,
                'title' => 'faculty_edit',
            ],
            [
                'id'    => 42,
                'title' => 'faculty_show',
            ],
        ];

        Permission::insert($permissions);
    }
}
