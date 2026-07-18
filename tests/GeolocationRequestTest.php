<?php

namespace JordJD\LaravelGeolocationRequest\Tests;

use JordJD\Countries\Country;
use JordJD\Geolocation\Interfaces\LocationProviderInterface;
use JordJD\LaravelGeolocationRequest\Http\Requests\GeolocationRequest;
use PHPUnit\Framework\TestCase;

class GeolocationRequestTest extends TestCase
{
    public function testUsesTheRequestIpWithAnInjectedProvider()
    {
        $request = GeolocationRequest::create('/', 'GET', [], [], [], [
            'REMOTE_ADDR' => '203.0.113.10',
        ]);
        $provider = new RecordingLocationProvider();
        $request->setLocationProvider($provider);

        $country = $request->country();

        $this->assertSame('203.0.113.10', $provider->ip);
        $this->assertInstanceOf(Country::class, $country);
        $this->assertSame('GB', $country->isoCodeAlpha2);
    }

    public function testReturnsNullWhenNoIpIsAvailable()
    {
        $request = new GeolocationRequest();

        $this->assertNull($request->country());
    }
}

class RecordingLocationProvider implements LocationProviderInterface
{
    public $ip;

    public function getCountryByIP(string $ip): ?Country
    {
        $this->ip = $ip;
        $country = new Country();
        $country->isoCodeAlpha2 = 'GB';

        return $country;
    }
}
