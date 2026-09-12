<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('class_rooms')) {
            Schema::create('class_rooms', function (Blueprint $table) {
                $table->bigIncrements('class_room_id');
                $table->string('room_code', 50)->nullable();
                $table->string('room_name', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('enrollments')) {
            return;
        }

        Schema::dropIfExists('class_rooms');
    }
};
