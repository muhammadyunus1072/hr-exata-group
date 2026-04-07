<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportMasterUser implements ToCollection
{
    public function collection(Collection $rows)
    {
        // skip header
        $rows->skip(1)->each(function ($row) {
            $nik = $row[0];
            $name = $row[1];
            $jenis_kelamin = $row[2];
            $tanggal_lahir = $row[3];
            $tempat_lahir = $row[4];
            $nomor_identitas = $row[5];
            $tanggal_masuk = $row[6];
            $no_telp_pribadi = $row[12];
            $npwp = $row[13];
            $no_rekening = $row[14];
            $nama_bank = $row[15];
            // $divisi = $row[1];
            // $no_telp_kantor = $row[2];
            // $alamat_domisili = $row[4];
            // $alamat_sesuai_ktp = $row[5];
            // $nama_dan_hubungan = $row[6];
            // $no_telp_hubungan = $row[7];
            // $nama_dan_hubungan_2 = $row[8];
            // $no_telp_hubungan_2 = $row[9];
            // $email = $row[10];

            // $nama_dan_hubungan = explode(',', $nama_dan_hubungan);
            // $nama_kontak_darurat = isset($nama_dan_hubungan[0]) ? $nama_dan_hubungan[0] : null;
            // $hubungan_kontak_darurat = isset($nama_dan_hubungan[1]) ? $nama_dan_hubungan[1] : null;
            // $nama_dan_hubungan_2 = explode(',', $nama_dan_hubungan_2);
            // $nama_kontak_darurat_2 = isset($nama_dan_hubungan_2[0]) ? $nama_dan_hubungan_2[0] : null;
            // $hubungan_kontak_darurat_2 = isset($nama_dan_hubungan_2[1]) ? $nama_dan_hubungan_2[1] : null;

            $data = [
                'nomor_karyawan' => $nik,
                'name' => $name,
                'username' => $name,
                'jenis_kelamin' => $jenis_kelamin,
                'tanggal_lahir' => Date::excelToDateTimeObject($tanggal_lahir),
                'tempat_lahir' => $tempat_lahir,
                'nomor_identitas' => $nomor_identitas,
                'tanggal_masuk' => Date::excelToDateTimeObject($tanggal_masuk),
                'no_telp_pribadi' => $no_telp_pribadi,
                'npwp' => $npwp,
                'no_rekening' => $no_rekening,
                'nama_bank' => $nama_bank,
                'password' => Hash::make('123exata'),
            ];
            logger($data);
            $user = User::updateOrCreate(
                ['email' => Str::random(5) . "@gmail.com",],
                $data
            );
            $user->assignRole('Karyawan');


            // EmployeeEmergencyContactRepository::create([
            //     'user_id' => $user->id,
            //     'nama' => $nama_kontak_darurat,
            //     'no_telp' => $no_telp_hubungan,
            //     'hubungan_keluarga' => $hubungan_kontak_darurat,
            // ]);
            // EmployeeEmergencyContactRepository::create([
            //     'user_id' => $user->id,
            //     'nama' => $nama_kontak_darurat_2,
            //     'no_telp' => $no_telp_hubungan_2,
            //     'hubungan_keluarga' => $hubungan_kontak_darurat_2,
            // ]);
        });
    }
}
