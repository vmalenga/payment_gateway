<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\Auth\AuthResource;

interface AuthRepositoryInterface
{
    public function login(array $data): array;

    public function verify(array $data): array;

    public function verifyToken(array $data): array;
}
