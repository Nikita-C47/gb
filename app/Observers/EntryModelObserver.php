<?php

namespace App\Observers;

use App\Models\Entry;
use App\Notifications\NewEntryNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Класс, представляющий наблюдатель за моделью записи.
 * @package App\Observers Классы-наблюдатели приложения.
 */
class EntryModelObserver
{
    /**
     * Обрабатывает создание записи.
     *
     * @param \App\Models\Entry $entry запись.
     * @return void
     */
    public function created(Entry $entry)
    {
        // Если уведомления включены
        if(config('app.enable_notifications')) {
            // Отправляем уведомление администратору системы
            Notification::route('mail', config('app.admin_email'))
                ->notify(new NewEntryNotification($entry->toArray()));
        }
    }

    /**
     * Handle the entry "updated" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function updated(Entry $entry)
    {
        //
    }

    /**
     * Handle the entry "deleted" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function deleted(Entry $entry)
    {
        //
    }

    /**
     * Handle the entry "restored" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function restored(Entry $entry)
    {
        //
    }

    /**
     * Handle the entry "force deleted" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function forceDeleted(Entry $entry)
    {
        //
    }
}
