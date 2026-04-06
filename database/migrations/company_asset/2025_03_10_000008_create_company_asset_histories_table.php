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
        Schema::create('company_asset_histories', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_company_asset_histories', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_asset_histories');
        Schema::dropIfExists('_history_company_asset_histories');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->unsignedBigInteger('company_asset_id');
        $table->unsignedBigInteger('assigned_user_id');
        $table->dateTime('assigned_at')->nullable();
        $table->dateTime('returned_at')->nullable();
        $table->string('status_kondisi')->nullable();
        $table->string('status_barang')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
