<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Класс, представляющий миграцию создания таблицы с записями в гостевой книге.
 */
class CreateEntriesTable extends Migration
{
    /**
     * Запускает миграцию.
     *
     * @return void
     */
    public function up()
    {
        // Таблица с записями
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Откатывает миграцию.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
