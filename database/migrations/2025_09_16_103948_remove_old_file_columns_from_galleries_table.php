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
        Schema::table('galleries', function (Blueprint $table) {
            // Remove old single-file columns since we now use gallery_media table
            $table->dropColumn([
                'file_path',
                'file_name',
                'file_type',
                'mime_type',
                'file_size'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Restore old columns if needed
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->enum('file_type', ['image', 'video'])->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
        });
    }
};
