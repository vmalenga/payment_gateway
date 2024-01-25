<?php

namespace App\Http\Controllers\API\System;

use App\Http\Controllers\Controller;
use App\Models\System\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    protected CountryRepositoryInterface $country;

    public function __construct(CountryRepositoryInterface $country)
    {
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->country->all($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json($this->country->save($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return response()->json($this->country->get($country), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        return response()->json($this->country->save($request->all(), $country), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        return response()->json($this->country->delete($country), Response::HTTP_NO_CONTENT);
    }
}
