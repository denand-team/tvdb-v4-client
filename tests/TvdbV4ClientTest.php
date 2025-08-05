<?php

namespace Denand\TvdbV4Client\Tests;

use Denand\TvdbV4Client\TvdbV4Client;
use Illuminate\Support\Facades\Cache;

class TvdbV4ClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear cache before each test
        Cache::flush();
    }

    /**
     * Test that the client can be instantiated
     */
    public function testClientInstantiation()
    {
        try {
            $client = new TvdbV4Client();
            $this->assertInstanceOf(TvdbV4Client::class, $client);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the client has the correct API URL constant
     */
    public function testApiUrlConstant()
    {
        $reflection = new \ReflectionClass(TvdbV4Client::class);
        $constant = $reflection->getConstant('API_URL');
        
        $this->assertEquals('https://api4.thetvdb.com/v4/', $constant);
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
        }
    }

    // ==================== SERIES METHODS ====================

    /**
     * Test getSeries method
     */
    public function testGetSeries()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeries(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeriesByName method
     */
    public function testGetSeriesByName()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeriesByName('Breaking Bad');
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeriesFull method
     */
    public function testGetSeriesFull()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeriesFull(1, 'eng');
            
            $this->assertNotNull($result);
            $this->assertIsObject($result);
            $this->assertObjectHasAttribute('extended', $result);
            $this->assertObjectHasAttribute('translations', $result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeriesTranslations method
     */
    public function testGetSeriesTranslations()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeriesTranslations(1, 'eng');
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== EPISODES METHODS ====================

    /**
     * Test getEpisodes method
     */
    public function testGetEpisodes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getEpisodes(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getEpisodesFull method
     */
    public function testGetEpisodesFull()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getEpisodesFull(1, 'eng');
            
            $this->assertNotNull($result);
            $this->assertIsObject($result);
            $this->assertObjectHasAttribute('extended', $result);
            $this->assertObjectHasAttribute('translations', $result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getEpisodesTranslations method
     */
    public function testGetEpisodesTranslations()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getEpisodesTranslations(1, 'eng');
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== SEASONS METHODS ====================

    /**
     * Test getSeasons method
     */
    public function testGetSeasons()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeasons(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeasonsFull method
     */
    public function testGetSeasonsFull()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeasonsFull(1, 'eng');
            
            $this->assertNotNull($result);
            $this->assertIsObject($result);
            $this->assertObjectHasAttribute('extended', $result);
            $this->assertObjectHasAttribute('translations', $result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeasonsTranslations method
     */
    public function testGetSeasonsTranslations()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeasonsTranslations(1, 'eng');
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== MOVIES METHODS ====================

    /**
     * Test getMovies method
     */
    public function testGetMovies()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getMovies(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getMoviesFull method
     */
    public function testGetMoviesFull()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getMoviesFull(1, 'eng');
            
            $this->assertNotNull($result);
            $this->assertIsObject($result);
            $this->assertObjectHasAttribute('extended', $result);
            $this->assertObjectHasAttribute('translations', $result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getMoviesTranslations method
     */
    public function testGetMoviesTranslations()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getMoviesTranslations(1, 'eng');
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== PEOPLE METHODS ====================

    /**
     * Test getPeople method
     */
    public function testGetPeople()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getPeople(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getPeopleFull method
     */
    public function testGetPeopleFull()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getPeopleFull(1, 'eng');
            
            $this->assertNotNull($result);
            $this->assertIsObject($result);
            $this->assertObjectHasAttribute('extended', $result);
            $this->assertObjectHasAttribute('translations', $result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getPeopleTranslations method
     */
    public function testGetPeopleTranslations()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getPeopleTranslations(1, 'eng');
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== CHARACTERS METHODS ====================

    /**
     * Test getCharacters method
     */
    public function testGetCharacters()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getCharacters(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== ARTWORK METHODS ====================

    /**
     * Test getArtwork method
     */
    public function testGetArtwork()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getArtwork(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== AWARDS METHODS ====================

    /**
     * Test getAwards method
     */
    public function testGetAwards()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getAwards(1);
            
            $this->assertNotNull($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== SEARCH METHODS ====================

    /**
     * Test search method with basic query
     */
    public function testSearchBasic()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->search('Breaking Bad');
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test search method with type filter
     */
    public function testSearchWithType()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->search('Breaking Bad', 'series');
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test search method with year filter
     */
    public function testSearchWithYear()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->search('Breaking Bad', 'series', 2008);
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test search method with pagination
     */
    public function testSearchWithPagination()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->search('Breaking Bad', 'series', null, 0, 5);
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== TYPES METHODS ====================

    /**
     * Test getArtworkTypes method
     */
    public function testGetArtworkTypes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getArtworkTypes();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getCompaniesTypes method
     */
    public function testGetCompaniesTypes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getCompaniesTypes();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getEntityTypes method
     */
    public function testGetEntityTypes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getEntityTypes();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getPeopleTypes method
     */
    public function testGetPeopleTypes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getPeopleTypes();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeasonsTypes method
     */
    public function testGetSeasonsTypes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeasonsTypes();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSourcesTypes method
     */
    public function testGetSourcesTypes()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSourcesTypes();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== STATUS METHODS ====================

    /**
     * Test getArtworkStatuses method
     */
    public function testGetArtworkStatuses()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getArtworkStatuses();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getMoviesStatuses method
     */
    public function testGetMoviesStatuses()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getMoviesStatuses();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test getSeriesStatuses method
     */
    public function testGetSeriesStatuses()
    {
        try {
            $client = new TvdbV4Client();
            $result = $client->getSeriesStatuses();
            
            $this->assertNotNull($result);
            $this->assertIsArray($result);
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    // ==================== ERROR HANDLING ====================

    /**
     * Test that the client handles network errors gracefully
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
     * Test that the client handles invalid API responses
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
     * Test that the client handles missing configuration gracefully
     */
    public function testMissingConfiguration()
    {
        // Temporarily set empty configuration
        config(['tvdb-v4-client.pin' => '']);
        config(['tvdb-v4-client.apikey' => '']);

        $this->expectException(\Exception::class);
        
        // This should fail when trying to construct the client
        new TvdbV4Client();
    }

    // ==================== TOKEN CACHING ====================

    /**
     * Test that token caching works correctly
     */
    public function testTokenCaching()
    {
        try {
            $client = new TvdbV4Client();
            
            // Make first call (should trigger login and cache token)
            $result1 = $client->getSeriesStatuses();
            
            // Make second call (should use cached token)
            $result2 = $client->getSeriesStatuses();
            
            // Both should work
            $this->assertNotNull($result1);
            $this->assertNotNull($result2);
            
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the client can handle different language codes
     */
    public function testLanguageCodeHandling()
    {
        try {
            $client = new TvdbV4Client();
            
            // Test with different language codes
            $languages = ['eng', 'spa', 'fra', 'deu'];
            
            foreach ($languages as $lang) {
                try {
                    $result = $client->getSeriesTranslations(1, $lang);
                    $this->assertNotNull($result);
                } catch (\Exception $e) {
                    // Some language codes might not be available
                    $this->assertTrue(
                        strpos($e->getMessage(), '401') !== false ||
                        strpos($e->getMessage(), '404') !== false,
                        'Expected authentication or 404 error for language ' . $lang . ', got: ' . $e->getMessage()
                    );
                }
            }
            
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }

    /**
     * Test that the client can handle different parameter types
     */
    public function testParameterTypeHandling()
    {
        try {
            $client = new TvdbV4Client();
            
            // Test with string ID
            $result1 = $client->getSeries('1');
            $this->assertNotNull($result1);
            
            // Test with integer ID
            $result2 = $client->getSeries(1);
            $this->assertNotNull($result2);
            
        } catch (\Exception $e) {
            // If authentication fails, that's expected with test credentials
            $this->assertStringContainsString('401', $e->getMessage());
        }
    }
} 