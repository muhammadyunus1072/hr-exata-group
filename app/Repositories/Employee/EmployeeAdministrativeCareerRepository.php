<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeAdministrativeCareer;
use App\Repositories\MasterDataRepository;

class EmployeeAdministrativeCareerRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeAdministrativeCareer::class;
    }

    public static function datatable()
    {
        return EmployeeAdministrativeCareer::query();
    }
}
