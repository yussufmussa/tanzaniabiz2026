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
        Schema::create('business_listing_social_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_listing_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('social_media_id')->constrained()->onDelete('cascade')->onUpdate('cascade');;
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_listing_social_media');
    }
};
