<?php

use App\Enums\PackageStatus;
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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('package_no')->nullable()->index();
            $table->string('image_path', 255)->nullable();
            $table->string('recipient_phone_no', 30)->nullable()->index();
            $table->foreignId('recipient_unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('storage_location_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('arrived_at');
            $table->dateTime('collected_at')->nullable();
            $table->foreignId('collected_by_id')->nullable()->constrained('collectors')->nullOnDelete();
            $table->unsignedTinyInteger('status')->default(PackageStatus::Arrived)->comment('Refer to PackageStatus enum class.');
            $table->integer('one_time_storage_fee')->default(0)->comment('Value in smallest unit (cent).');
            $table->integer('daily_storage_fee')->default(0)->comment('Value in smallest unit (cent).');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
