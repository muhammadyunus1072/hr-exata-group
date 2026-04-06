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
        Schema::create('employee_company_accounts', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_employee_company_accounts', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_company_accounts');
        Schema::dropIfExists('_history_employee_company_accounts');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->bigInteger('user_id')->unsigned();
        $table->string('platform')->nullable(); // Gmail, Meta, etc
        $table->string('username')->nullable();
        $table->string('password')->nullable();
        $table->text('catatan')->nullable();


        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
