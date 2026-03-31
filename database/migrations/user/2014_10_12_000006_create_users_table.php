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
        $table->string('nama_karyawan');
        $table->string('nomor_identitas');
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->string('jenis_kelamin');
        $table->string('agama');
        $table->string('status_perkawinan');
        $table->string('pendidikan_terakhir');

        // Contact Information
        $table->string('no_telp_pribadi')->nullable();
        $table->string('no_telp_kantor')->nullable();
        $table->string('email_pribadi')->nullable();

        // Address Information
        $table->text('alamat_domisili')->nullable();
        $table->text('alamat_sesuai_ktp')->nullable();

        // Apresiasi
        $table->string('jenis_apresiasi');
        $table->text('keterangan_apresiasi')->nullable();

        $table->string('status')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
