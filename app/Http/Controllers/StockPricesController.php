<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EndOfDayData;
use App\Models\Fundamental;

use App\Http\Resources\StockPriceCollection;
use App\Http\Resources\watchlistCollection;

use Carbon\Carbon;

class StockPricesController extends Controller
{
    public function __construct(Fundamental $fundamental, EndOfDayData $eod) {
      $this->fundamental = $fundamental;
      $this->eod = $eod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        
        $lastYear = Carbon::now()->subYear(1);
        $watchlistItems = $this->fundamental->groupBy('code')->get();
        $eods = $this->eod->whereIn('code',$watchlistItems->pluck('code'))->whereDate('created_at','>',$lastYear)->orderBy('created_at','desc')->get();

        return new StockPriceCollection($eods);
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
        //
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
        //
    }
}
