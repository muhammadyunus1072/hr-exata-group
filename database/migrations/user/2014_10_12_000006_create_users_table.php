<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_users', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('_history_users');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('email', 'users_email_idx');
            $table->index('username', 'users_username_idx');
        }

        $table->string('name');
        $table->string('email');
        $table->string('username');
        $table->string('password');
        $table->datetime('email_verified_at')->nullable()->default(null);
        $table->rememberToken();

        //----------//
        // EMPLOYEE //
        //----------//
        $table->string('nomor_karyawan')->nullable();

        // Personal Information
        $table->string('nomor_identitas')->nullable();
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->string('jenis_kelamin')->nullable();
        $table->string('agama')->nullable();
        $table->string('status_perkawinan')->nullable();
        $table->string('pendidikan_terakhir')->nullable();
        $table->string('keterangan_pendidikan_terakhir')->nullable();
        $table->string('golongan_darah')->nullable();
        $table->string('zodiac')->nullable();
        $table->string('divisi')->nullable();
        $table->string('nama_bank')->nullable();
        $table->string('no_rekening')->nullable();

        // Contact Information
        $table->string('no_telp_pribadi')->nullable();
        $table->string('no_telp_kantor')->nullable();
        $table->date('tenggat_waktu_pembayaran')->nullable();

        // Address Information
        $table->text('alamat_domisili')->nullable();
        $table->text('alamat_sesuai_ktp')->nullable();

        // Apresiasi
        $table->string('jenis_apresiasi')->nullable();
        $table->text('keterangan_apresiasi')->nullable();

        $table->date('tanggal_masuk')->nullable();
        $table->date('tanggal_keluar')->nullable();
        $table->text('alasan_keluar')->nullable();
        $table->bigInteger("last_employee_career_id")->unsigned()->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
