<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\PartnerCreateRequest;
use App\Models\Auth\Partner;
use App\Repositories\Interfaces\PartnerRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerController extends Controller
{
    protected PartnerRepositoryInterface $partner;

    public function __construct(PartnerRepositoryInterface $partner)
    {
        $this->partner = $partner;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->partner->all($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartnerCreateRequest $request)
    {
        return response()->json($this->partner->save($request->all(), null), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return response()->json($this->partner->get($partner), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        return response()->json($this->partner->save($request->all(), $partner), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        return response()->json($this->partner->delete($partner), Response::HTTP_NO_CONTENT);
    }
}
