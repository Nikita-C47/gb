<?php

namespace App\Observers;

use App\Models\Entry;
use App\Notifications\NewEntryNotification;
use Illuminate\Support\Facades\Notification;

class EntryModelObserver
{
    /**
     * Handle the entry "created" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function created(Entry $entry)
    {
        if(config('app.enable_notifications')) {
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
