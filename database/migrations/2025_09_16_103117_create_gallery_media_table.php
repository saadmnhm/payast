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
        Schema::create('gallery_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('file_type'); // 'image' or 'video'
            $table->string('mime_type');
            $table->integer('file_size')->nullable();
            $table->integer('original_size')->nullable(); // Before compression
            $table->integer('sort_order')->default(0);
            $table->boolean('is_compressed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_media');
    }
};
