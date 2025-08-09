<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

$permissions = [
            'show-index',

            'create-role',
            'edit-role',
            'delete-role',
            'show-roles',


            'create-user',
            'edit-user',
            'delete-user',
            'show-users',

            'print-invoice',
            'view-invoice',
            'show-invoice',
            'create-invoice',
            'edit-invoice',
            'delete-invoice',
            'show-deleted-invoice',
            'edit-status-invoice',
            'excel-import-invoice',
            'add-attachments-invoice',
            'delete-attachments',

            'add-image-invoice',
            'delete-image-invoice',
            'show-image-invoice',


            'create-product',
            'edit-product',
            'delete-product',
            'show-product',


            'create-section',
            'edit-section',
            'delete-section',
            'show-section',




        ];
// $permissions = [

//         'الفواتير',
//         'قائمة الفواتير',
//         'الفواتير المدفوعة',
//         'الفواتير المدفوعة جزئيا',
//         'الفواتير الغير مدفوعة',
//         'ارشيف الفواتير',
//         'التقارير',
//         'تقرير الفواتير',
//         'تقرير العملاء',
//         'المستخدمين',
//         'قائمة المستخدمين',
//         'صلاحيات المستخدمين',
//         'الاعدادات',
//         'المنتجات',
//         'الاقسام',

//         'اضافة فاتورة',
//         'حذف الفاتورة',
//         'تصدير اكسيل ',
//         'تغير حالة الدفع',
//         'تعديل الفاتورة',
//         'ارشفة الفاتورة',
//         'طباعةالفاتورة',
//         'اضافة مرفق',
//         'حذف المرفق',

//         'اضافة مستخدم',
//         'تعديل مستخدم',
//         'حذف مستخدم',

//         'عرض صلاحية',
//         'اضافة صلاحية',
//         'تعديل صلاحية',
//         'حذف صلاحية',

//         'اضافة منتج',
//         'تعديل منتج',
//         'حذف منتج',

//         'اضافة قسم',
//         'تعديل قسم',
//         'حذف قسم',
//         'الاشعارات',

// ];

foreach ($permissions as $permission) {

Permission::create(['name' => $permission]);
}


}

}
