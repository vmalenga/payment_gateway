<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\Country\CountryCollection;
use App\Http\Resources\Country\CountryResource;
use App\Models\System\Country;

interface CountryRepositoryInterface
{
    public function all(array $params = []): CountryCollection;

    public function save(array $data, Country $country = null): CountryResource;

    public function get(Country $country): CountryResource;

    public function delete(Country $country): void;
}
