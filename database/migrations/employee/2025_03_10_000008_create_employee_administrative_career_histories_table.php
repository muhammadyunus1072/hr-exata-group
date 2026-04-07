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
        Schema::create('employee_administrative_career_histories', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_employee_administrative_career_histories', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_administrative_career_histories');
        Schema::dropIfExists('_history_employee_administrative_career_histories');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->bigInteger('user_id')->unsigned();
        $table->bigInteger('administrative_career_id')->unsigned();
        $table->dateTime('tanggal_mulai')->nullable();
        $table->dateTime('tanggal_selesai')->nullable();
        $table->dateTime('perkiraan_tanggal_selesai')->nullable();
        $table->integer('durasi')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
