<?php

namespace App\Providers;

use App\Models\Entry;
use App\Observers\EntryModelObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Класс, представляющий провайдер сервисов приложения.
 * @package App\Providers Провайдеры приложения.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует сервисы приложения.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Загружает сервисы приложения.
     *
     * @return void
     */
    public function boot()
    {
        // Регистрируем наблюдатель для модели записи
        Entry::observe(EntryModelObserver::class);
    }
}
