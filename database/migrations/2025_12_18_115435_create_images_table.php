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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path'); // Путь к файлу в storage
            $table->string('type')->default('gallery'); // avatar, post, cover
            $table->unsignedBigInteger('user_id'); // Кто загрузил

            // Для связи с другими сущностями (пост, коммент и т.д.)
            $table->string('imageable_type')->nullable(); // App\Models\Post
            $table->unsignedBigInteger('imageable_id')->nullable();

            $table->timestamps();

            // Индексы
            $table->index('user_id');
            $table->index('type');
            $table->index(['imageable_type', 'imageable_id']);

            // Внешний ключ
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
