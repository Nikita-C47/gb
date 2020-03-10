<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Класс, представляющий миграцию добавления столбца количества выводимых записей настраницу в таблицу пользователей.
 */
class AddRowsCountToUsersTable extends Migration
{
    /**
     * Запускает миграцию.
     *
     * @return void
     */
    public function up()
    {
        // Добавляем столбец с количеством строк
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('rows_count')->nullable();
        });
    }

    /**
     * Откатывает миграцию.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rows_count');
        });
    }
}
