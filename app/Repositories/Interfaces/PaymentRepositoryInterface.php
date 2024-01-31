<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\Payment\PaymentCollection;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\System\Payment;

interface PaymentRepositoryInterface
{
    public function all(array $params = []): PaymentCollection;

    public function save(array $data, Payment $country = null): PaymentResource;

    public function get(Payment $payment): PaymentResource;

    public function delete(Payment $payment): void;
}
