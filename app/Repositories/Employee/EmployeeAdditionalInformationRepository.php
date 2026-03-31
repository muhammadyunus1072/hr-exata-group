<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeAdditionalInformation;
use App\Repositories\MasterDataRepository;

class EmployeeAdditionalInformationRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeAdditionalInformation::class;
    }

    public static function datatable()
    {
        return EmployeeAdditionalInformation::query();
    }
}
