<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
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
                'name' => 'user_display',
                'display_name' => 'عرض المستخدمين',
                'description' => 'عرض المستخدمين'
            ],

            [
                'name' => 'user_create',
                'display_name' => 'اضافة مستخدمين',
                'description' => 'اضافة مستخدمين'
            ],

            [
                'name' => 'user_update',
                'display_name' => 'تعديل المستخدمين',
                'description' => 'تعديل المستخدمين'
            ],
            [
                'name' => 'user_delete',
                'display_name' => 'حذف مستخدمين',
                'description' => 'حذف مستخدمين'
            ],
            ////////
            [
                'name' => 'donor_display',
                'display_name' => 'عرض متبرعين',
                'description' => 'عرض متبرعين'
            ],
            [
                'name' => 'donor_create',
                'display_name' => 'اضافة متبرعين',
                'description' => 'اضافة متبرعين'
            ],

            [
                'name' => 'donor_update',
                'display_name' => 'تعديل متبرعين',
                'description' => 'تعديل متبرعين'
            ],
            [
                'name' => 'donor_delete',
                'display_name' => 'حذف متبرعين',
                'description' => 'حذف متبرعين'
            ],

            //////////
            [
                'name' => 'broker_display',
                'display_name' => 'عرض الوسطاء',
                'description' => 'عرض الوسطاء'
            ],
            [
                'name' => 'broker_create',
                'display_name' => 'اضافة وسطاء',
                'description' => 'اضافة وسطاء'
            ],

            [
                'name' => 'broker_update',
                'display_name' => 'تعديل وسطاء',
                'description' => 'تعديل وسطاء'
            ],
            [
                'name' => 'broker_delete',
                'display_name' => 'حذف وسطاء',
                'description' => 'حذف وسطاء'
            ],
            ////////
            [
                'name' => 'project_display',
                'display_name' => 'عرض المشاريع',
                'description' => 'عرض المشاريع'
            ],
            [
                'name' => 'project_create',
                'display_name' => 'اضافة مشاريع',
                'description' => 'اضافة مشاريع',
            ],

            [
                'name' => 'project_update',
                'display_name' => 'تعديل مشاريع',
                'description' => 'تعديل مشاريع'
            ],
            [
                'name' => 'project_delete',
                'display_name' => 'حذف مشاريع',
                'description' => 'حذف مشاريع'
            ],
            //////
            [
                'name' => 'donation_display',
                'display_name' => 'عرض التبرعات',
                'description' => 'عرض التبرعات'
            ],
            [
                'name' => 'donation_create',
                'display_name' => 'اضافة تبرعات',
                'description' => 'اضافة تبرعات'
            ],

            [
                'name' => 'donation_update',
                'display_name' => 'تعديل تبرعات',
                'description' => 'تعديل تبرعات'
            ],
            [
                'name' => 'donation_delete',
                'display_name' => 'حذف تبرعات',
                'description' => 'حذف تبرعات'
            ],

            //////
            [
                'name' => 'import',
                'display_name' => 'استيراد',
                'description' => 'استيراد'
            ],
            [
                'name' => 'export',
                'display_name' => 'تصدير',
                'description' => 'تصدير'
            ],
            ////
            [
                'name' => 'search',
                'display_name' => 'صفحة البحث',
                'description' =>  'صفحة البحث'
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}