# Laravel Geolocation Request

The Laravel Geolocation Request package provides an easy
way to geolocate requests to their country of origin, simply
by calling a `$request->country()` method.

## Installation

To install the Laravel Geolocation Request package, just
run the following Composer command.

```bash
composer require jord-jd/laravel-geolocation-request
``` 

## Usage

To use geolocation enabled requests within your Laravel controller 
methods, you can replace the `use Illuminate\Http\Request` line 
at the top of your controllers, as shown in the usage example below.

Once done, you can simple call the `$request->country()` method to 
perform geolocation and return the origin country of the active 
request based on its IP address. The country is returned as an object 
containing many properties, such as the country name and ISO codes.

```php
<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use DivineOmega\LaravelGeolocationRequest\Http\Requests\GeolocationRequest as Request;

class UserController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Perform geolocation, and return a country object.
        $country = $request->country();
        
        $user = new \App\User();
        $user->name = $request->name;
        $user->countryName = $country->name;
        $user->countryCode = $country->isoCodeAlpha3;
        
        $user->save();
        
        // ...
    }
}
```

If you are using custom request objects, you can
change them to extend the provided `GeolocationRequest` class.
If you unable to extend your custom request object, or 
simply do not wish to, you can add geolocation functionality
by using the provided `GeolocatableRequest` trait.