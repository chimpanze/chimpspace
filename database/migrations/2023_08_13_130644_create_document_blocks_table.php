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
        Schema::create('document_blocks', function (Blueprint $table) {
            $table->ulid();
            $table->timestamps();
            $table->softDeletesDatetime();
            $table->foreignUlid('document_id')->nullable();
            $table->unsignedInteger('order')->nullable()->index();
            $table->char('type', '12');
            $table->longText('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_blocks');
    }
};
