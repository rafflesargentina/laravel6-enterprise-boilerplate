<?php

namespace App\Providers;

use App\Listeners\PruneOldTokens;
use App\Listeners\RevokeOldTokens;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Events\{ AccessTokenCreated, RefreshTokenCreated };

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
	AccessTokenCreated::class => [
	    RevokeOldTokens::class,
	],    
	RefreshTokenCreated::class => [
	    PruneOldTokens::class,
	],
	Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
