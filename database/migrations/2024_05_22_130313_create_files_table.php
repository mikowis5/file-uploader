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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->string('filename');
            $table->string('path');
            $table->unsignedBigInteger('size');
            $table->string('mime_type');

            $table->unsignedInteger('width')->default(0);
            $table->unsignedInteger('height')->default(0);

            $table->text('exif')->nullable();
            $table->text('iptc')->nullable();

            $table->string('username');
            $table->string('email');

            $table->float('temperature')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
