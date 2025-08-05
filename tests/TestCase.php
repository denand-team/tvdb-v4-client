<?php

namespace Denand\TvdbV4Client\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Denand\TvdbV4Client\TvdbV4ClientServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            TvdbV4ClientServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Set up test environment
        $app['config']->set('tvdb-v4-client.pin', env('THETVDB_PIN', 'test_pin'));
        $app['config']->set('tvdb-v4-client.apikey', env('THETVDB_APIKEY', 'test_apikey'));
    }
} 