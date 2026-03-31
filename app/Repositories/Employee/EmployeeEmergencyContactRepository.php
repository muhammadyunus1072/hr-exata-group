<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeEmergencyContact;
use App\Repositories\MasterDataRepository;

class EmployeeEmergencyContactRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeEmergencyContact::class;
    }

    public static function datatable()
    {
        return EmployeeEmergencyContact::query();
    }
}
