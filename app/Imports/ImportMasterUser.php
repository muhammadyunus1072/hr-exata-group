<?php

namespace App\Imports;

use App\Models\User;
use App\Repositories\Employee\EmployeeEmergencyContactRepository;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ImportMasterUser implements ToCollection
{
    public function collection(Collection $rows)
    {


        // skip header
        $rows->skip(1)->each(function ($row) {
            $name = $row[0];
            $divisi = $row[1];
            $no_telp_kantor = $row[2];
            $no_telp_pribadi = $row[3];
            $alamat_domisili = $row[4];
            $alamat_sesuai_ktp = $row[5];
            $nama_dan_hubungan = $row[6];
            $no_telp_hubungan = $row[7];
            $nama_dan_hubungan_2 = $row[8];
            $no_telp_hubungan_2 = $row[9];
            $email = $row[10];
            $nama_bank = $row[11];
            $no_rekening = $row[12];

            $nama_dan_hubungan = explode(',', $nama_dan_hubungan);
            $nama_kontak_darurat = isset($nama_dan_hubungan[0]) ?? null;
            $hubungan_kontak_darurat = isset($nama_dan_hubungan[1]) ?? null;
            $nama_dan_hubungan_2 = explode(',', $nama_dan_hubungan_2);
            $nama_kontak_darurat_2 = isset($nama_dan_hubungan_2[0]) ?? null;
            $hubungan_kontak_darurat_2 = isset($nama_dan_hubungan_2[1]) ?? null;

            $data = [
                'name' => $name,
                'username' => $name,
                'divisi' => $divisi,
                'no_telp_kantor' => $no_telp_kantor,
                'no_telp_pribadi' => $no_telp_pribadi,
                'alamat_domisili' => $alamat_domisili,
                'alamat_sesuai_ktp' => $alamat_sesuai_ktp,
                'email' => $email,
                'nama_bank' => $nama_bank,
                'no_rekening' => $no_rekening,
                'password' => Hash::make('123exata'),
            ];
            $user = User::updateOrCreate(
                ['email' => $email,],
                $data
            );
            $user->assignRole('Karyawan');


            EmployeeEmergencyContactRepository::create([
                'user_id' => $user->id,
                'nama' => $nama_kontak_darurat,
                'no_telp' => $no_telp_hubungan,
                'hubungan_keluarga' => $hubungan_kontak_darurat,
            ]);
            EmployeeEmergencyContactRepository::create([
                'user_id' => $user->id,
                'nama' => $nama_kontak_darurat_2,
                'no_telp' => $no_telp_hubungan_2,
                'hubungan_keluarga' => $hubungan_kontak_darurat_2,
            ]);
        });
    }
}
