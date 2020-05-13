<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PostUpdated' => [
            'App\Listeners\PostUpdatedListener',
        ],
        'App\Events\PostDeleted' => [
            'App\Listeners\PostDeletedListener',
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\VKontakte\VKontakteExtendSocialite@handle'
        ],
    ];
}
