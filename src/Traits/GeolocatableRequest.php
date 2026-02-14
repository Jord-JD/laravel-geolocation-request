<?php

namespace JordJD\LaravelGeolocationRequest\Traits;

use JordJD\Countries\Country;
use JordJD\DOFileCachePSR6\CacheItemPool;
use JordJD\Geolocation\Interfaces\LocationProviderInterface;
use JordJD\Geolocation\Locator;

trait GeolocatableRequest
{
    private $locationProvider;

    /**
     * Set an alternative location provider for geolocation.
     *
     * @param LocationProviderInterface $locationProvider
     */
    public function setLocationProvider(LocationProviderInterface $locationProvider)
    {
        $this->locationProvider = $locationProvider;
    }

    /**
     * Creates an instance of the Locator class, and sets up an appropriate
     * location provider and cache.
     *
     * @return Locator
     */
    private function getLocator()
    {
        $locator = new Locator();

        if ($this->locationProvider) {
            $locator->setLocationProvider($this->locationProvider);
        }

        $cacheItemPool = new CacheItemPool();
        $cacheItemPool->changeConfig([
            'cacheDirectory' => __DIR__.'/../../cache/',
        ]);

        $locator->setCache($cacheItemPool);

        return $locator;
    }

    /**
     * Retrieve the origin country of the request, based on its IP address.
     *
     * @return Country
     */
    public function country()
    {
        $ip = $this->ip();

        if (!$ip) {
            return null;
        }

        return $this->getLocator()->getCountryByIP($ip);
    }

    /**
     * Overrides the custom request object ip() method to look at the active request object.
     *
     * This is required because Laravel's custom request objects do not appear to have
     * access to the IP address, or in fact, any server variables.
     *
     * @return string|null
     */
    public function ip()
    {
        return request()->ip();
    }
}