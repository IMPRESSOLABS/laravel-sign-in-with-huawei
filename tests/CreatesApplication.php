<?php

namespace GeneaLabs\LaravelSignInWithApple\Tests;

use ImpressoLabs\LaravelSignInWithHuawei\Providers\ServiceProvider;
use ImpressoLabs\LaravelSignInWithHuawei\Tests\Fixtures\Providers\TestingServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Socialite\SocialiteServiceProvider;

trait CreatesApplication
{
    protected function setUp(): void
    {
        parent::setUp();

        \Orchestra\Testbench\Dusk\Options::withUI();
        $this->artisan("view:clear");
        $this->artisan("cache:clear");
        $this->artisan("config:clear");
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.redis.client', "predis");
        $app->make(Kernel::class)
            ->pushMiddleware(StartSession::class);

        $app->make("view")
            ->addLocation(__DIR__ . "/Fixtures/resources/views");
    }

    protected function getPackageProviders($app)
    {
        return [
            SocialiteServiceProvider::class,
            ServiceProvider::class,
            TestingServiceProvider::class,
        ];
    }
}
