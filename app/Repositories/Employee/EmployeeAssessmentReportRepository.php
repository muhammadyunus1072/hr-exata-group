<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeAssessmentReport;
use App\Repositories\MasterDataRepository;

class EmployeeAssessmentReportRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeAssessmentReport::class;
    }

    public static function datatable()
    {
        return EmployeeAssessmentReport::query();
    }
}
