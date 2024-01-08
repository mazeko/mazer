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
        Schema::create('submenu', function (Blueprint $table) {
            $table->id();
            $table->string('submenu_id', 32)->unique();
            $table->string('submenu_title', 32);
            $table->string('menu_id');
            $table->foreign('menu_id')->references('menu_id')->on('menu');
            $table->string('submenu_link', 128);
            $table->string('submenu_icon', 64)->nullable();
            $table->string('is_active', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submenu');
    }
};
