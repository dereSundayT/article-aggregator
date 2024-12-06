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
        Schema::create('articles', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('source_id')->constrained('sources');
            $table->foreignId('author_id')->constrained('authors');
            //
            $table->longText('content');
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->longText('image_url')->nullable();
            $table->timestamp('published_at');






            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
