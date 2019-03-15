<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GisRank;

class GisRanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get == "checkIfExist") {
          $watchlistItemRank = GisRank::where('watchlist_item_id', $request->watchlist_item_id)->first();
          if($watchlistItemRank) return response()->json($watchlistItemRank);
          else return response()->json(false);
        }
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
        $watchlistItem = GisRank::create([
          'code' => $request->code,
          'watchlist_item_id' => $request->watchlist_item_id,
        ]);

        if($watchlistItem) return response()->json("success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $watchlistItemRank = GisRank::find($id);
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
        $watchlistItem = GisRank::where('watchlist_item_id',$id)->first();
        $watchlistItem->update([
          $request->key => $request->value,
        ]);

        if($watchlistItem) return response()->json("success");
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
