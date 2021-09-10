<?php

namespace Denand\TvdbV4Client;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Denand\TvdbV4Client\Skeleton\SkeletonClass
 */
class TvdbV4ClientFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tvdb-v4-client';
    }
}
