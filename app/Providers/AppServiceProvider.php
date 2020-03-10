<?php

namespace App\Providers;

use App\Models\Entry;
use App\Observers\EntryModelObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Entry::observe(EntryModelObserver::class);
    }
}
