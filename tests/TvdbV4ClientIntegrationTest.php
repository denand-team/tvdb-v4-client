<?php

namespace Denand\TvdbV4Client\Tests;

use Denand\TvdbV4Client\TvdbV4Client;

class TvdbV4ClientIntegrationTest extends TestCase
{
    /**
     * Test real login with actual credentials (if available)
     * This test will be skipped if credentials are not set
     */
    public function testRealLogin()
    {
        $pin = env('THETVDB_PIN');
        $apikey = env('THETVDB_APIKEY');

        // Skip test if credentials are not set
        if (empty($pin) || empty($apikey) || $pin === 'test_pin' || $apikey === 'test_apikey') {
            $this->markTestSkipped('Real credentials not available for integration test');
        }

        try {
            $client = new TvdbV4Client();
            
            // Try to make a simple API call to test login
            $result = $client->getSeries(1);
            
            // If we get here, login was successful
            $this->assertNotNull($result);
            $this->assertIsObject($result);
            
        } catch (\Exception $e) {
            $this->fail('Login failed: ' . $e->getMessage());
        }
    }

    /**
     * Test that the client can authenticate and make a search request
     */
    public function testSearchWithRealCredentials()
    {
        $pin = env('THETVDB_PIN');
        $apikey = env('THETVDB_APIKEY');

        // Skip test if credentials are not set
        if (empty($pin) || empty($apikey) || $pin === 'test_pin' || $apikey === 'test_apikey') {
            $this->markTestSkipped('Real credentials not available for integration test');
        }

        try {
            $client = new TvdbV4Client();
            
            // Try to search for a popular TV show
            $result = $client->search('Breaking Bad', 'series', null, 0, 1);
            
            // If we get here, login and search were successful
            $this->assertNotNull($result);
            $this->assertIsArray($result);
            
        } catch (\Exception $e) {
            $this->fail('Search failed: ' . $e->getMessage());
        }
    }

    /**
     * Test that the client can get series types (a simple API call)
     */
    public function testGetSeriesStatusesWithRealCredentials()
    {
        $pin = env('THETVDB_PIN');
        $apikey = env('THETVDB_APIKEY');

        // Skip test if credentials are not set
        if (empty($pin) || empty($apikey) || $pin === 'test_pin' || $apikey === 'test_apikey') {
            $this->markTestSkipped('Real credentials not available for integration test');
        }

        try {
            $client = new TvdbV4Client();
            
            // Try to get series statuses (a simple API call)
            $result = $client->getSeriesStatuses();
            
            // If we get here, login and API call were successful
            $this->assertNotNull($result);
            $this->assertIsArray($result);
            
        } catch (\Exception $e) {
            $this->fail('Get series statuses failed: ' . $e->getMessage());
        }
    }
} 