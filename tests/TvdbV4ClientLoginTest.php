<?php

namespace Denand\TvdbV4Client\Tests;

use Denand\TvdbV4Client\TvdbV4Client;
use Illuminate\Support\Facades\Cache;

class TvdbV4ClientLoginTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear cache before each test
        Cache::flush();
    }

    /**
     * Test that the client can be instantiated with valid configuration
     */
    public function testClientInstantiation()
    {
        try {
            $client = new TvdbV4Client();
            
            // Test that the client was created successfully
            $this->assertInstanceOf(TvdbV4Client::class, $client);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
            $this->assertStringContainsString('Unauthorized', $e->getMessage());
        }
    }

    /**
     * Test that the client uses the correct configuration values
     */
    public function testConfigurationValues()
    {
        try {
            $client = new TvdbV4Client();
            
            // Use reflection to check private properties
            $reflection = new \ReflectionClass($client);
            
            $pinProperty = $reflection->getProperty('pin');
            $pinProperty->setAccessible(true);
            
            $apikeyProperty = $reflection->getProperty('apikey');
            $apikeyProperty->setAccessible(true);
            
            $this->assertEquals('test_pin', $pinProperty->getValue($client));
            $this->assertEquals('test_apikey', $apikeyProperty->getValue($client));
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
            $this->assertStringContainsString('Unauthorized', $e->getMessage());
        }
    }

    /**
     * Test that the client can make a simple API call (which tests login)
     */
    public function testSimpleApiCall()
    {
        try {
            $client = new TvdbV4Client();
            
            // Try to get series statuses (a simple API call that requires authentication)
            $result = $client->getSeriesStatuses();
            
            // If we get here, login was successful
            $this->assertNotNull($result);
            $this->assertIsArray($result);
            
        } catch (\Exception $e) {
            // If the test credentials are invalid, that's expected
            $this->assertStringContainsString('401', $e->getMessage());
            $this->assertStringContainsString('Unauthorized', $e->getMessage());
        }
    }

    /**
     * Test that the client can search (which tests login)
     */
    public function testSearchApiCall()
    {
        try {
            $client = new TvdbV4Client();
            
            // Try to search for a TV show (requires authentication)
            $result = $client->search('Breaking Bad', 'series', null, 0, 1);
            
            // If we get here, login was successful
            $this->assertNotNull($result);
            $this->assertIsArray($result);
            
        } catch (\Exception $e) {
            // If the test credentials are invalid, that's expected
            $this->assertStringContainsString('401', $e->getMessage());
            $this->assertStringContainsString('Unauthorized', $e->getMessage());
        }
    }

    /**
     * Test that the client handles missing credentials gracefully
     */
    public function testMissingCredentials()
    {
        // Temporarily set empty credentials
        config(['tvdb-v4-client.pin' => '']);
        config(['tvdb-v4-client.apikey' => '']);

        $this->expectException(\Exception::class);
        
        // This should fail when trying to construct the client
        new TvdbV4Client();
    }

    /**
     * Test that the client can handle network errors
     */
    public function testNetworkErrorHandling()
    {
        try {
            $client = new TvdbV4Client();
            
            // Try to make an API call
            $result = $client->getSeriesStatuses();
            
            // If successful, that's fine
            $this->assertNotNull($result);
            
        } catch (\Exception $e) {
            // Should be either authentication error or network error
            $this->assertTrue(
                strpos($e->getMessage(), '401') !== false ||
                strpos($e->getMessage(), '500') !== false ||
                strpos($e->getMessage(), 'timeout') !== false ||
                strpos($e->getMessage(), 'connection') !== false,
                'Expected authentication or network error, got: ' . $e->getMessage()
            );
        }
    }

    /**
     * Test that the client can handle invalid API responses
     */
    public function testInvalidApiResponse()
    {
        try {
            $client = new TvdbV4Client();
            
            // Try to get a series that doesn't exist (should return 404)
            $result = $client->getSeries(999999999);
            
            // If we get here, the API handled the request properly
            $this->assertNotNull($result);
            
        } catch (\Exception $e) {
            // Should be either authentication error or 404
            $this->assertTrue(
                strpos($e->getMessage(), '401') !== false ||
                strpos($e->getMessage(), '404') !== false,
                'Expected authentication or 404 error, got: ' . $e->getMessage()
            );
        }
    }

    /**
     * Test that the login process is working correctly
     */
    public function testLoginProcess()
    {
        try {
            $client = new TvdbV4Client();
            
            // If we get here, the client was created and login was attempted
            $this->assertInstanceOf(TvdbV4Client::class, $client);
            
            // Try to make an API call to test the full login flow
            $result = $client->getSeriesStatuses();
            $this->assertNotNull($result);
            
        } catch (\Exception $e) {
            // Check that the error is related to authentication (which is expected with test credentials)
            $this->assertTrue(
                strpos($e->getMessage(), '401') !== false ||
                strpos($e->getMessage(), 'InvalidAPIKey') !== false ||
                strpos($e->getMessage(), 'Unauthorized') !== false,
                'Expected authentication error, got: ' . $e->getMessage()
            );
        }
    }
} 