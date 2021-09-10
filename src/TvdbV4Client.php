<?php

namespace Denand\TvdbV4Client;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TvdbV4Client
{
    /**
     * Стартовый Url API Tvmaze
     * @var string
     */
    const API_URL = 'https://api4.thetvdb.com/v4/';

    /**
     * TvdbV4Client constructor.
     */
    public function __construct()
    {
    }

    public function auth()
    {
        var_dump(config('pin'));
    }




}
