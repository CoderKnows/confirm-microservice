<?php

namespace App\Providers;

use App\Services\ConfirmService;
use App\Services\EmailService;
use App\Services\PhoneService;
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

    public function boot()
    {
        app()->singleton(ConfirmService::class, function () {
            return new ConfirmService();
        });

        app()->singleton(EmailService::class, function () {
            return new EmailService();
        });

        app()->singleton(PhoneService::class, function () {
            return new PhoneService();
        });
    }
}
