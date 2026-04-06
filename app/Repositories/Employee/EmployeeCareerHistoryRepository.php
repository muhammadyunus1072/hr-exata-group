<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeCareerHistory;
use App\Repositories\MasterDataRepository;

class EmployeeCareerHistoryRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeCareerHistory::class;
    }

    public static function datatable()
    {
        return EmployeeCareerHistory::query();
    }
}
