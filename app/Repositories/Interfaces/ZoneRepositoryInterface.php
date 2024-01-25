<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\Zone\ZoneCollection;
use App\Http\Resources\Zone\ZoneResource;
use App\Models\System\Zone;

interface ZoneRepositoryInterface
{
    public function all(array $params = []): ZoneCollection;

    public function save(array $data, Zone $zone = null): ZoneResource;

    public function get(Zone $zone): ZoneResource;

    public function delete(Zone $zone): void;
}
