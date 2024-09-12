<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTypeSeeder::class,
            StateSeeder::class,
            DistrictSeeder::class,
            MunicipalitySeeder::class,
            RolePermissionSeeder::class,
            SchoolSeederSeeder::class,
            UserSeeder::class,
            AcademicSessionSeeder::class,
            ClassSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            ExpenseHeadSeeder::class,
            FeeTypeSeeder::class,
            InclusiveQuotaSeeder::class,
            IncomeHeadSeeder::class,
            LeaveTypeSeeder::class,
            SectionSeeder::class,
            SubjectSeeder::class,
            AttendanceTypesSeeder::class,
            MarksGradeSeeder::class,
            BloodGroupSeeder::class,
        ]);
    }
}
