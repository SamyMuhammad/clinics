<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Permissions
        Permission::create(['name' => 'view stats', 'ar_name' => 'عرض الإحصائيات', 'guard_name' => 'admin']);
        
        Permission::create(['name' => 'control settings', 'ar_name' => 'التحكم في الإعدادات', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view roles', 'ar_name' => 'عرض الصلاحيات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show roles', 'ar_name' => 'مشاهدة الصلاحيات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create roles', 'ar_name' => 'إضافة الصلاحيات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit roles', 'ar_name' => 'تعديل الصلاحيات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete roles', 'ar_name' => 'حذف الصلاحيات', 'guard_name' => 'admin']);
        
        Permission::create(['name' => 'view admins', 'ar_name' => 'عرض المديرين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show admins', 'ar_name' => 'مشاهدة المديرين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create admins', 'ar_name' => 'إضافة المديرين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit admins', 'ar_name' => 'تعديل المديرين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete admins', 'ar_name' => 'حذف المديرين', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view users', 'ar_name' => 'عرض الأعضاء', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show users', 'ar_name' => 'مشاهدة الأعضاء', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create users', 'ar_name' => 'إضافة الأعضاء', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit users', 'ar_name' => 'تعديل الأعضاء', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete users', 'ar_name' => 'حذف الأعضاء', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view patients', 'ar_name' => 'عرض المرضى', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show patients', 'ar_name' => 'مشاهدة المرضى', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create patients', 'ar_name' => 'إضافة المرضى', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit patients', 'ar_name' => 'تعديل المرضى', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete patients', 'ar_name' => 'حذف المرضى', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view blocked patients', 'ar_name' => 'عرض المرضى المحظورين', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view files', 'ar_name' => 'عرض الملفات', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'show files', 'ar_name' => 'مشاهدة الملفات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create files', 'ar_name' => 'إضافة الملفات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit files', 'ar_name' => 'تعديل الملفات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete files', 'ar_name' => 'حذف الملفات', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view clinics', 'ar_name' => 'عرض العيادات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show clinics', 'ar_name' => 'مشاهدة العيادات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create clinics', 'ar_name' => 'إضافة العيادات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit clinics', 'ar_name' => 'تعديل العيادات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete clinics', 'ar_name' => 'حذف العيادات', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view rays', 'ar_name' => 'عرض أنواع الآشعة', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show rays', 'ar_name' => 'مشاهدة أنواع الآشعة', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create rays', 'ar_name' => 'إضافة أنواع الآشعة', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit rays', 'ar_name' => 'تعديل أنواع الآشعة', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete rays', 'ar_name' => 'حذف أنواع الآشعة', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view raysRequests', 'ar_name' => 'عرض طلبات الآشعة', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view medical tests', 'ar_name' => 'عرض أنواع التحاليل', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show medical tests', 'ar_name' => 'مشاهدة أنواع التحاليل', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create medical tests', 'ar_name' => 'إضافة أنواع التحاليل', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit medical tests', 'ar_name' => 'تعديل أنواع التحاليل', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete medical tests', 'ar_name' => 'حذف أنواع التحاليل', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view medical tests requests', 'ar_name' => 'عرض طلبات التحاليل', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view reservations', 'ar_name' => 'عرض الحجوزات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete reservations', 'ar_name' => 'حذف الحجوزات', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view companies', 'ar_name' => 'عرض الشركات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'show companies', 'ar_name' => 'مشاهدة الشركات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create companies', 'ar_name' => 'إضافة الشركات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit companies', 'ar_name' => 'تعديل الشركات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete companies', 'ar_name' => 'حذف الشركات', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view discounts', 'ar_name' => 'عرض التخفيضات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create discounts', 'ar_name' => 'إضافة التخفيضات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit discounts', 'ar_name' => 'تعديل التخفيضات', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete discounts', 'ar_name' => 'حذف التخفيضات', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view rooms', 'ar_name' => 'عرض الغرف', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create rooms', 'ar_name' => 'إضافة الغرف', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit rooms', 'ar_name' => 'تعديل الغرف', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete rooms', 'ar_name' => 'حذف الغرف', 'guard_name' => 'admin']);

        // Users Permissions
        Permission::create(['name' => 'view patients', 'ar_name' => 'عرض المرضى', 'guard_name' => 'web']);
        Permission::create(['name' => 'show patients', 'ar_name' => 'مشاهدة المرضى', 'guard_name' => 'web']);
        Permission::create(['name' => 'create patients', 'ar_name' => 'إضافة المرضى', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit patients', 'ar_name' => 'تعديل المرضى', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete patients', 'ar_name' => 'حذف المرضى', 'guard_name' => 'web']);
        Permission::create(['name' => 'view blocked patients', 'ar_name' => 'عرض المرضى المحظورين', 'guard_name' => 'web']);
        
        Permission::create(['name' => 'make reservations', 'ar_name' => 'تسجيل الحجوزات', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete reservations', 'ar_name' => 'حذف الحجوزات', 'guard_name' => 'web']);
    }
}
