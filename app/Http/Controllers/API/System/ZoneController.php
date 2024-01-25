<?php

namespace App\Http\Controllers\API\System;

use App\Http\Controllers\Controller;
use App\Models\System\Zone;
use App\Repositories\Interfaces\ZoneRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneController extends Controller
{
    protected ZoneRepositoryInterface $zone;

    public function __construct(ZoneRepositoryInterface $zone)
    {
        $this->zone = $zone;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->zone->all($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json($this->zone->save($request->all(), null), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        return response()->json($this->zone->get($zone), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        return response()->json($this->zone->save($request->all(), $zone), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        return response()->json($this->zone->delete($zone), Response::HTTP_NO_CONTENT);
    }
}
