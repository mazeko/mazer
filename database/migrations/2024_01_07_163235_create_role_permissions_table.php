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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('menu_roleid');
            $table->foreign('menu_roleid')->references('menu_roleid')->on('menu_role');
            $table->integer('is_read')->default(0)->nullable();
            $table->integer('is_create')->default(0)->nullable();
            $table->integer('is_update')->default(0)->nullable();
            $table->integer('is_delete')->default(0)->nullable();
            $table->integer('is_export')->default(0)->nullable();
            $table->integer('is_verify')->default(0)->nullable();
            $table->string('created_by', 64)->nullable();
            $table->string('updated_by', 64)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
