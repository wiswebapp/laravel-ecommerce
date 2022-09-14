<?php

namespace App\Providers;

use App\Models\Banner;
use App\Events\UserRegisterEvent;
use App\Observers\BannerObserver;
use App\Listeners\UserRegisterListner;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        UserRegisterEvent::class => [
            UserRegisterListner::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Banner::observe(BannerObserver::class);
    }
}
