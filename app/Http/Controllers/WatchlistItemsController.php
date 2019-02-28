<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EndOfDayData;
use App\Models\WatchlistItem;

use App\Http\Resources\WatchlistItemCollection;

class WatchlistItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get == "watchlist_item") {
          $items = WatchlistItem::where('watchlist_id', $request->watchlist_id)->get();
          foreach($items as $item){
            $item->stock = EndOfDayData::where('code',$item->code)->orderBy('created_at','desc')->first();
          }
          return new WatchlistItemCollection($items);
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
        $item = WatchlistItem::firstOrCreate([
          'code' => $request->stockCode,
          'watchlist_id' => $request->watchlistId,
        ]);

        if($item) return response()->json('Success add watchlist item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = WatchlistItem::find($id)->delete();

        if($item) return response()->json("Success delete watchlist item.");
    }
}
