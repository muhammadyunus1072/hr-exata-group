<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeCareerStatus;
use App\Repositories\MasterDataRepository;

class EmployeeCareerStatusRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeCareerStatus::class;
    }

    public static function datatable()
    {
        return EmployeeCareerStatus::query();
    }
}
