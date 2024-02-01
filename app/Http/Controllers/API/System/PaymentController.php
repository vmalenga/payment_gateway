<?php

namespace App\Http\Controllers\API\System;

use App\Http\Controllers\Controller;
use App\Models\System\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    protected PaymentRepositoryInterface $payment;

    public function __construct(PaymentRepositoryInterface $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->payment->all($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json($this->payment->save($request->all(), null), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json($this->payment->get($payment), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        return response()->json($this->payment->save($request->all(), $payment), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        return response()->json($this->payment->delete($payment), Response::HTTP_NO_CONTENT);
    }
}
