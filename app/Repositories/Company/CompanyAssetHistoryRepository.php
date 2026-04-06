<?php

namespace App\Repositories\Company;

use App\Models\Company\CompanyAssetHistory;
use App\Repositories\MasterDataRepository;

class CompanyAssetHistoryRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return CompanyAssetHistory::class;
    }

    public static function datatable()
    {
        return CompanyAssetHistory::query();
    }
}
