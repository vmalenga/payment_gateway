<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\Partner\PartnerCollection;
use App\Http\Resources\Partner\PartnerResource;
use App\Models\Auth\Partner;

interface PartnerRepositoryInterface
{
    public function all(array $params = []): PartnerCollection;

    public function save(array $data, Partner $partner = null): PartnerResource;

    public function get(Partner $partner): PartnerResource;

    public function delete(Partner $partner): void;
}
