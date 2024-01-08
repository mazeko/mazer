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
        Schema::create('menu_role', function (Blueprint $table) {
            $table->id();
            $table->string('menu_roleid', 32)->unique();
            $table->string('role_id', 32);
            $table->string('menu_id');
            $table->foreign('menu_id')->references('menu_id')->on('menu');
            $table->string('submenu_id');
            $table->foreign('submenu_id')->references('submenu_id')->on('submenu');
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
        Schema::dropIfExists('menu_role');
    }
};
