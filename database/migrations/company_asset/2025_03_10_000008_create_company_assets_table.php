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
        Schema::create('company_assets', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_company_assets', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_assets');
        Schema::dropIfExists('_history_company_assets');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->unsignedBigInteger('assigned_user_id')->nullable();
        $table->dateTime('assigned_at')->nullable();
        $table->string('nama_barang');
        $table->string('serial_number')->nullable();
        $table->string('status_kondisi')->nullable();
        $table->string('status_barang')->nullable();
        $table->string('status_pembelian')->nullable();
        $table->string('divisi')->nullable();
        $table->string('brand')->nullable();
        $table->text('keterangan')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
