<?php

namespace Denand\TvdbV4Client;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TvdbV4Client
{
    /**
     * Url API TVDB API V4
     * @var string
     */
    const API_URL = 'https://api4.thetvdb.com/v4/';

    /**
     * TvdbV4Client constructor.
     */
    public function __construct()
    {
        // Auth data
        $this->pin = config('tvdb-v4-client')['pin'];
        $this->apikey = config('tvdb-v4-client')['apikey'];

        // Init Guzzle
        $this->tvdb_api = new Client();

        // Auth tokens
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Accept'        => 'application/json',
        ];
    }


    /**
     * @param $method - Called method
     * @param $id - ID
     * @param bool $extended - use extended data or not
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getData($method, $id, bool $extended = false, $params = [])
    {
        // Check if extended needed
        $ext = ($extended) ? '/extended' : '';

        $url = self::API_URL . $method . '/' . $id . $ext;
        if (! empty($params))  {
            $url .= '?'. http_build_query($params);
        }
        $data = $this->tvdb_api->get($url, [
            'headers' => $this->headers
        ])->getBody()->getContents();

        $data = json_decode($data);

        return $data->data;
    }


    /**
     * @param $method - Called method
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getTypeData($method)
    {
        $data = $this->tvdb_api->get(self::API_URL.$method.'/types', [
            'headers' => $this->headers
        ])->getBody()->getContents();

        $data = json_decode($data);

        return $data->data;
    }


    /**
     * @param $method - Called method
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getStatusData($method)
    {
        $data = $this->tvdb_api->get(self::API_URL.$method.'/statuses', [
            'headers' => $this->headers
        ])->getBody()->getContents();

        $data = json_decode($data);

        return $data->data;
    }

    /**
     * @param $method - Called method
     * @param $id - ID
     * @param bool $extended - use extended data or not
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getTranslationsData($method, $id, $lang)
    {
        $data = $this->tvdb_api->get(self::API_URL.$method.'/'.$id.'/translations/'.$lang, [
            'headers' => $this->headers
        ])->getBody()->getContents();

        $data = json_decode($data);

        return $data->data;
    }



    /**
     * @param $id - TheTVDB ID
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeries($id, $params = [])
    {
        return $this->getData('series', $id, true, $params);
    }

    /**
     * @param $id - TheTVDB ID
     * @param string $lang
     * @return \stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEpisodesFull ($id, string $lang = 'eng')
    {
        $data = new \stdClass();
        $data->extended = $this->getEpisodes($id, [
            'meta' => 'episodes',
            'short' => 'false',
        ]);
        $data->translations = $this->getEpisodesTranslations($id, $lang);

        return $data;
    }

    /**
     * @param $id - ID of episode on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEpisodes($id)
    {
        return $this->getData('episodes', $id, true);
    }


    /**
     * @param $id - ID of Season on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeasons($id)
    {
        return $this->getData('seasons', $id, true);
    }

    /**
     * @param $id - ID of Movie on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMovies($id)
    {
        return $this->getData('movies', $id, true);
    }

    /**
     * @param $id - ID of Artwork on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getArtwork($id)
    {
        return $this->getData('artwork', $id, true);
    }

    /**
     * @param $id - ID of Artwork on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAwards($id)
    {
        return $this->getData('awards', $id, true);
    }

    /**
     * @param $id - ID of People on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPeople($id)
    {
        return $this->getData('people', $id, true);
    }


    /**
     * @param $id - ID of Characters on TheTVDB
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCharacters($id)
    {
        return $this->getData('characters', $id, false);
    }

    /**
     * Search on TheTVDB
     *
     * @param string $query - additional search query param string
     * @param string $type - restrict results to entity type movie|series|person|company
     * @param number $year - restrict results to a year for movie|series
     * @param number $offset - offset results
     * @param number $limit - limit results
     */
    public function search($query, $type = null, $year = null, $offset = null, $limit = null)
    {
        // Check if extended params needed
        $type = ($type) ? '&type='.$type : '';
        $year = ($year) ? '&year='.$year : '';
        $offset = ($offset) ? '&offset='.$offset : '';
        $limit = ($limit) ? '&limit='.$limit : '';


        $uri = self::API_URL.'search?q='.urlencode($query).$type.$year.$offset.$limit;

        $data = $this->tvdb_api->get($uri, [
            'headers' => $this->headers
        ])->getBody()->getContents();

        $data = json_decode($data);

        return $data->data;
    }


    /**
     * Get TV Series By Name
     *
     * @param string $name - TV Series Name
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeriesByName($name)
    {
        $found = $this->search($name, 'series', null, null, 1);
        $data = $this->getSeries($found[0]->tvdb_id);

        return $data;
    }


    /**
     * Get a list of artworkType records
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getArtworkTypes()
    {
        return $this->getTypeData('artwork');
    }

    /**
     * Get all company type records
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCompaniesTypes()
    {
        return $this->getTypeData('companies');
    }

    /**
     * Get the active entity types
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEntityTypes()
    {
        return $this->getTypeData('entities');
    }

    /**
     * Get list of peopleType records
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPeopleTypes()
    {
        return $this->getTypeData('people');
    }

    /**
     * Get season type records
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeasonsTypes()
    {
        return $this->getTypeData('seasons');
    }

    /**
     * Get list of sourceType records
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSourcesTypes()
    {
        return $this->getTypeData('sources');
    }

    /**
     * Get list of artwork status records.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getArtworkStatuses()
    {
        return $this->getStatusData('artwork');
    }


    /**
     * Get list of Movie status records.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMoviesStatuses()
    {
        return $this->getStatusData('movies');
    }

    /**
     * Get list of Series status records.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeriesStatuses()
    {
        return $this->getStatusData('series');
    }


    /**
     * Get Movie Translations records.
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMoviesTranslations($id, $lang)
    {
        return $this->getTranslationsData('movies', $id, $lang = 'eng');
    }

    /**
     * Get Series Translations records.
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeriesTranslations($id, $lang)
    {
        return $this->getTranslationsData('series', $id, $lang = 'eng');
    }


    /**
     * Get people translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPeopleTranslations($id, $lang)
    {
        return $this->getTranslationsData('people', $id, $lang = 'eng');
    }


    /**
     * Get seasons translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeasonsTranslations($id, $lang)
    {
        return $this->getTranslationsData('seasons', $id, $lang = 'eng');
    }

    /**
     * Get episodes translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEpisodesTranslations($id, $lang)
    {
        return $this->getTranslationsData('episodes', $id, $lang = 'eng');
    }

    /**
     * Get series extended record + translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeriesFull ($id, string $lang = 'eng')
    {
        $data = new \stdClass();
        $data->extended = $this->getSeries($id);
        $data->translations = $this->getSeriesTranslations($id, $lang);

        return $data;
    }

    /**
     * Get seasons extended record + translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeasonsFull ($id, string $lang = 'eng')
    {
        $data = new \stdClass();
        $data->extended = $this->getSeasons($id);
        $data->translations = $this->getSeasonsTranslations($id, $lang);

        return $data;
    }


    /**
     * Get people extended record + translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPeopleFull ($id, string $lang = 'eng')
    {
        $data = new \stdClass();
        $data->extended = $this->getPeople($id);
        $data->translations = $this->getPeopleTranslations($id, $lang);

        return $data;
    }

    /**
     * Get movie extended record + translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMoviesFull ($id, string $lang = 'eng')
    {
        $data = new \stdClass();
        $data->extended = $this->getMovies($id);
        $data->translations = $this->getMoviesTranslations($id, $lang);

        return $data;
    }

    /**
     * Get episodes extended record + translation record
     *
     * @param string $id - ID on TheTVDB
     * @param string $lang - Translation language, eng default
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeriesFull ($id, string $lang = 'eng')
    {
        $data = new \stdClass();
        $data->extended = $this->getSeries($id, [
            'meta' => 'episodes',
            'short' => 'false',
        ]);
        $data->translations = $this->getSeriesTranslations($id, $lang);

        return $data;
    }

    /**
     * Get TheTVDB API V4 Token
     *
     * @return string
     */
    private function getToken()
    {
        $headers = [
            'apikey' => $this->apikey,
            'pin'    => $this->pin
        ];

        $api_url = self::API_URL;

        $tvdbApi = $this->tvdb_api;

        // Retrieve token
        $token = Cache::remember($this->pin, 2500000, function () use ($headers, $api_url, $tvdbApi) {

            $token = $tvdbApi->post($api_url.'login', ['json' => $headers])->getBody()->getContents();

            return $token;
        });

        return json_decode($token)->data->token;
    }
}
