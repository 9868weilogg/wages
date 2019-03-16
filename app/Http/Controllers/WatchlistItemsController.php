<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EndOfDayData;
use App\Models\Stock;
use App\Models\WatchlistItem;

use App\Http\Resources\WatchlistItemCollection;

use App\Services\WatchlistItemService;

class WatchlistItemsController extends Controller
{
    private $watchlistItemService;
    private $eod;
    private $stock;
    private $watchlistItem;

    public function __construct(watchlistItemService $watchlistItemService, EndOfDayData $eod, Stock $stock, WatchlistItem $watchlistItem) {
      $this->watchlistItemService = $watchlistItemService;
      $this->eod = $eod;
      $this->stock = $stock;
      $this->watchlistItem = $watchlistItem;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get == "watchlist_item") {
          $items = $this->watchlistItem->where('watchlist_id', $request->watchlist_id)->get();
          foreach($items as $item){
            $item->stock = $this->eod->where('code',$item->code)->orderBy('created_at','desc')->first();
            $item->name = $this->stock->where('code',$item->code)->first()->short_name;
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
        // $item = WatchlistItem::firstOrCreate([
        //   'code' => $request->stockCode,
        //   'watchlist_id' => $request->watchlistId,
        // ]);

        $created = $this->watchlistItemService->create($request);

        if($created) return response()->json('Success add watchlist item');
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
        // $item = WatchlistItem::find($id)->delete();
        $deleted = $this->watchlistItemService->delete($id);

        if($deleted) return response()->json("Success delete watchlist item.");
    }
}
