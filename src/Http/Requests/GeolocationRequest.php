<?php

namespace JordJD\LaravelGeolocationRequest\Http\Requests;

use JordJD\LaravelGeolocationRequest\Traits\GeolocatableRequest;
use Illuminate\Http\Request;

class GeolocationRequest extends Request
{
    use GeolocatableRequest;
}