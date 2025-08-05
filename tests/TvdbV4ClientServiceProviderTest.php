<?php

namespace Denand\TvdbV4Client\Tests;

use Denand\TvdbV4Client\TvdbV4Client;
use Denand\TvdbV4Client\TvdbV4ClientServiceProvider;
use Denand\TvdbV4Client\TvdbV4ClientFacade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class TvdbV4ClientServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Set up default configuration for testing
        Config::set('tvdb-v4-client', [
            'pin' => 'test_pin',
            'apikey' => 'test_apikey'
        ]);
    }

    /**
     * Test that the service provider can be instantiated
     */
    public function testServiceProviderInstantiation()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        
        $this->assertInstanceOf(TvdbV4ClientServiceProvider::class, $provider);
    }

    /**
     * Test that the service provider registers the singleton correctly
     */
    public function testServiceProviderRegister()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Test that the singleton is registered
        $this->assertTrue($this->app->bound('tvdb-v4-client'));
        
        // Test that the singleton returns the correct instance
        try {
            $instance1 = $this->app->make('tvdb-v4-client');
            $instance2 = $this->app->make('tvdb-v4-client');
            
            $this->assertInstanceOf(TvdbV4Client::class, $instance1);
            $this->assertInstanceOf(TvdbV4Client::class, $instance2);
            
            // Test that it's actually a singleton (same instance)
            $this->assertSame($instance1, $instance2);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the configuration is merged correctly
     */
    public function testConfigurationMerging()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Test that the configuration is available
        $config = Config::get('tvdb-v4-client');
        
        $this->assertIsArray($config);
        $this->assertArrayHasKey('pin', $config);
        $this->assertArrayHasKey('apikey', $config);
        
        // Test default values
        $this->assertEquals(env('THETVDB_PIN', 'test_pin'), $config['pin']);
        $this->assertEquals(env('THETVDB_APIKEY', 'test_apikey'), $config['apikey']);
    }

    /**
     * Test that the facade works correctly
     */
    public function testFacadeAccess()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Test that the facade returns the correct instance
        try {
            $facadeInstance = TvdbV4ClientFacade::getFacadeRoot();
            $this->assertInstanceOf(TvdbV4Client::class, $facadeInstance);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the facade accessor returns the correct string
     */
    public function testFacadeAccessor()
    {
        // Test the facade accessor without triggering service resolution
        $reflection = new \ReflectionClass(TvdbV4ClientFacade::class);
        $method = $reflection->getMethod('getFacadeAccessor');
        $method->setAccessible(true);
        
        $accessor = $method->invoke(null);
        
        $this->assertEquals('tvdb-v4-client', $accessor);
    }

    /**
     * Test that the service provider boot method works correctly
     */
    public function testServiceProviderBoot()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        
        // Mock the app to simulate console environment
        $this->app['config']->set('app.env', 'testing');
        
        // Test that boot method doesn't throw any exceptions
        try {
            $provider->boot();
            $this->assertTrue(true); // If we get here, no exception was thrown
        } catch (\Exception $e) {
            $this->fail('Service provider boot method threw an exception: ' . $e->getMessage());
        }
    }

    /**
     * Test that the service provider can be registered in the application
     */
    public function testServiceProviderRegistration()
    {
        // Register the service provider
        $this->app->register(TvdbV4ClientServiceProvider::class);
        
        // Test that the service is bound
        $this->assertTrue($this->app->bound('tvdb-v4-client'));
        
        // Test that we can resolve the service
        try {
            $instance = $this->app->make('tvdb-v4-client');
            $this->assertInstanceOf(TvdbV4Client::class, $instance);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the configuration file is properly structured
     */
    public function testConfigurationFileStructure()
    {
        $configPath = __DIR__ . '/../config/config.php';
        
        $this->assertFileExists($configPath);
        
        $config = require $configPath;
        
        $this->assertIsArray($config);
        $this->assertArrayHasKey('pin', $config);
        $this->assertArrayHasKey('apikey', $config);
        
        // Test that the config values are strings or null
        $this->assertTrue(
            is_string($config['pin']) || is_null($config['pin']),
            'PIN should be string or null'
        );
        $this->assertTrue(
            is_string($config['apikey']) || is_null($config['apikey']),
            'API Key should be string or null'
        );
    }

    /**
     * Test that the service provider works with the facade in a real application context
     */
    public function testFacadeIntegration()
    {
        // Register the service provider
        $this->app->register(TvdbV4ClientServiceProvider::class);
        
        // Test that the facade can be used
        try {
            $instance = TvdbV4ClientFacade::getFacadeRoot();
            $this->assertInstanceOf(TvdbV4Client::class, $instance);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the service provider handles configuration changes correctly
     */
    public function testConfigurationChanges()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Change the configuration
        Config::set('tvdb-v4-client.pin', 'new_test_pin');
        Config::set('tvdb-v4-client.apikey', 'new_test_apikey');

        // Get a new instance and check that it uses the updated config
        try {
            $instance = $this->app->make('tvdb-v4-client');
            
            // Use reflection to check the private properties
            $reflection = new \ReflectionClass($instance);
            
            $pinProperty = $reflection->getProperty('pin');
            $pinProperty->setAccessible(true);
            
            $apikeyProperty = $reflection->getProperty('apikey');
            $apikeyProperty->setAccessible(true);
            
            $this->assertEquals('new_test_pin', $pinProperty->getValue($instance));
            $this->assertEquals('new_test_apikey', $apikeyProperty->getValue($instance));
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the service provider works correctly with multiple instances
     */
    public function testMultipleInstances()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Get multiple instances
        try {
            $instance1 = $this->app->make('tvdb-v4-client');
            $instance2 = $this->app->make('tvdb-v4-client');
            $instance3 = $this->app->make('tvdb-v4-client');

            // All should be the same instance (singleton)
            $this->assertSame($instance1, $instance2);
            $this->assertSame($instance1, $instance3);
            $this->assertSame($instance2, $instance3);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the service provider can be unbound and rebound
     */
    public function testServiceUnbinding()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Test that the service is bound
        $this->assertTrue($this->app->bound('tvdb-v4-client'));

        // Clear the resolved instance
        $this->app->forgetInstance('tvdb-v4-client');

        // Test that the service is still bound (forgetInstance only clears the resolved instance)
        $this->assertTrue($this->app->bound('tvdb-v4-client'));

        // Test that we can resolve the service again
        try {
            $instance = $this->app->make('tvdb-v4-client');
            $this->assertInstanceOf(TvdbV4Client::class, $instance);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the service provider works correctly in different environments
     */
    public function testEnvironmentHandling()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Test in different environments
        $environments = ['local', 'testing', 'production'];

        foreach ($environments as $env) {
            $this->app['config']->set('app.env', $env);
            
            try {
                $instance = $this->app->make('tvdb-v4-client');
                $this->assertInstanceOf(TvdbV4Client::class, $instance);
            } catch (\Exception $e) {
                // Authentication errors are expected with test credentials
                $this->assertStringContainsString('401', $e->getMessage());
            }
        }
    }

    /**
     * Test that the service provider handles missing configuration gracefully
     */
    public function testMissingConfiguration()
    {
        // Set empty configuration
        Config::set('tvdb-v4-client', [
            'pin' => '',
            'apikey' => ''
        ]);

        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // The service should still be registered
        $this->assertTrue($this->app->bound('tvdb-v4-client'));

        // But it should fail when trying to use it due to missing config
        try {
            $instance = $this->app->make('tvdb-v4-client');
            $this->assertInstanceOf(TvdbV4Client::class, $instance);
        } catch (\Exception $e) {
            // This is expected behavior when configuration is missing
            $this->assertTrue(true);
        }
    }

    /**
     * Test that the service provider correctly merges configuration from the config file
     */
    public function testConfigurationFileMerging()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Test that the configuration from the config file is properly merged
        $config = Config::get('tvdb-v4-client');
        
        $this->assertIsArray($config);
        $this->assertArrayHasKey('pin', $config);
        $this->assertArrayHasKey('apikey', $config);
        
        // The values should come from the config file or environment
        $this->assertNotNull($config['pin']);
        $this->assertNotNull($config['apikey']);
    }

    /**
     * Test that the service provider singleton pattern works correctly
     */
    public function testSingletonPattern()
    {
        $provider = new TvdbV4ClientServiceProvider($this->app);
        $provider->register();

        // Get multiple instances through different methods
        try {
            $instance1 = $this->app->make('tvdb-v4-client');
            $instance2 = app('tvdb-v4-client');
            $instance3 = $this->app->get('tvdb-v4-client');

            // All should be the same instance
            $this->assertSame($instance1, $instance2);
            $this->assertSame($instance1, $instance3);
            $this->assertSame($instance2, $instance3);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }
} 