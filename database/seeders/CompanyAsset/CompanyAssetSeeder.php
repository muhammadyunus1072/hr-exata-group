<?php

namespace Database\Seeders\CompanyAsset;

use App\Models\Company\CompanyAsset;
use App\Repositories\Account\UserRepository;
use App\Repositories\Company\CompanyAssetRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CompanyAssetSeeder extends Seeder
{
    public function run(): void
    {

        // HP
        $rows = Excel::toArray([], storage_path('app/seeders/company_asset_hp.xlsx'))[0];

        $header = array_shift($rows);

        foreach ($rows as $index => $row) {
            // logger($row[2]);

            $user = UserRepository::findBy([
                ['name', strtoupper($row[0])]
            ]);
            $validateData = [
                'assigned_user_id' => $user ? $user->id : null,
                'assigned_user_name' => $user ? $user->name : null,
                'nama_barang' => $row[3],
                'jenis' => CompanyAsset::JENIS_HANDPHONE,
                'serial_number' => null,
                'password' => $row[4],
                // 'status_barang' => CompanyAsset::status,
                'status_kondisi' => CompanyAsset::STATUS_KONDISI_BAIK,
                'status_pembelian' => CompanyAsset::STATUS_PEMBELIAN_BARU,
                'divisi' => $row[1],
                'brand' => $row[2],
                'keterangan' => null,
            ];
            CompanyAssetRepository::create($validateData);
        }
        $rows = Excel::toArray([], storage_path('app/seeders/company_asset_laptop.xlsx'))[0];

        $header = array_shift($rows);

        foreach ($rows as $index => $row) {
            // logger($row[2]);

            $user = UserRepository::findBy([
                ['name', strtoupper($row[0])]
            ]);
            $validateData = [
                'assigned_user_id' => $user ? $user->id : null,
                'assigned_user_name' => $user ? $user->name : null,
                'nama_barang' => $row[3],
                'jenis' => CompanyAsset::JENIS_LAPTOP,
                'serial_number' => $row[4],
                'password' => $row[5],
                // 'status_barang' => CompanyAsset::status,
                'status_kondisi' => CompanyAsset::STATUS_KONDISI_BAIK,
                'status_pembelian' => CompanyAsset::STATUS_PEMBELIAN_BARU,
                'divisi' => $row[1],
                'brand' => $row[2],
                'keterangan' => null,
            ];
            CompanyAssetRepository::create($validateData);
        }
    }
}
