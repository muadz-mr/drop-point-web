<?php

use App\Enums\StorageLocationStatus;
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
        Schema::create('storage_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('building', 20)->nullable()->index();
            $table->string('building_level', 10)->nullable()->index();
            $table->string('room', 20)->nullable()->index();
            $table->string('shelf', 10)->nullable()->index();
            $table->string('space', 10)->index();
            $table->unsignedTinyInteger('status')->default(StorageLocationStatus::Available)->comment('Refer StorageLocationStatus enum.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_locations');
    }
};
