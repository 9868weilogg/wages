<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GisRank;

use App\Services\GisRankService;

use App\Http\Resources\GisRankCollection;

class GisRanksController extends Controller
{
    private $gisRankService;

    public function __construct(GisRankService $gisRankService, GisRank $gisRank) {
      $this->gisRankService = $gisRankService;
      $this->gisRank = $gisRank;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $response = $this->gisRankService->checkIfExist($request);

      return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created = $this->gisRankService->create($request);

        if($created) return response()->json("success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $watchlistItemRank = $this->gisRank->find($id);

      return response()->json($watchlistItemRank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updated = $this->gisRankService->update($request, $id);

        if($updated) return response()->json("success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
