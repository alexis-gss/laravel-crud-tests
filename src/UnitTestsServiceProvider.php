<?php

namespace LaravelUnitTests;

use LaravelUnitTests\commands\TestMakeCommand;
use Illuminate\Support\ServiceProvider;

class UnitTestsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        /** Publish all files. */
        $this->publishes([
            __DIR__ . '/config/unit-tests.php'             => config_path('unit-tests.php'),
            __DIR__ . '/tests/CreatesApplication.php'      => base_path('tests/CreatesApplication.php'),
            __DIR__ . '/tests/TestCase.php'                => base_path('tests/TestCase.php'),
            __DIR__ . '/tests/Back/AuthenticationTest.php' => base_path('tests/Back/AuthenticationTest.php'),
            __DIR__ . '/others/phpunit.xml'                => base_path('phpunit.xml'),
        ]);

        /** Publish only config files. */
        $this->publishes([
            __DIR__ . '/config/unit-tests.php'             => config_path('unit-tests.php'),
            __DIR__ . '/tests/TestCase.php'                => base_path('tests/TestCase.php'),
            __DIR__ . '/tests/Back/AuthenticationTest.php' => base_path('tests/Back/AuthenticationTest.php'),
            __DIR__ . '/others/phpunit.xml'                => base_path('phpunit.xml'),
        ], 'config');

        /** Publish only authentication tests. */
        $this->publishes([
            __DIR__ . '/tests/Back/AuthenticationTest.php' => base_path('tests/Back/AuthenticationTest.php'),
        ], 'auth');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands([
            TestMakeCommand::class,
        ]);
    }
}
