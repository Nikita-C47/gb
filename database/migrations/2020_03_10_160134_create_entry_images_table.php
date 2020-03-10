<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Класс, представляющий миграцию создания таблицы с изображениями, прикрепленными к записи.
 */
class CreateEntryImagesTable extends Migration
{
    /**
     * Запускает миграцию.
     *
     * @return void
     */
    public function up()
    {
        // Таблица с изображениями
        Schema::create('entry_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_id');
            $table->string('name', 16);
            $table->string('original_name');
            $table->string('extension', 10);
            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
        });
    }

    /**
     * Откатывает миграцию.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_images', function (Blueprint $table) {
            $table->dropForeign(['entry_id']);
        });

        Schema::dropIfExists('entry_images');
    }
}
