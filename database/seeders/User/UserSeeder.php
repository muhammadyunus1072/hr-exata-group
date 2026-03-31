<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "Admin",
            'username' => "admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("123"),

            'nama_karyawan' => '-',
            'nomor_identitas' => '-',
            'tempat_lahir' => '-',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => '-',
            'agama' => '-',
            'status_perkawinan' => '-',
            'pendidikan_terakhir' => '-',
            'jenis_apresiasi' => User::APPRECIATION_JALAN_JALAN,
        ]);

        $user->assignRole('Super Admin');
    }
}
