<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EndOfDayData;
use App\Models\Stock;

use Carbon\Carbon;

class EndOfDayDatasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // EndOfDayData::uploadFrom2018();
        // EndOfDayData::crawlKlseScreenerForEOD();
        
        // dd(Carbon::today()->addDay()->format('Y-m-d H:i:s'));
        // dd(EndOfDayData::where('created_at',">=",Carbon::today()->format('Y-m-d H:i:s'))->where('created_at','<',Carbon::today()->addDay()->format('Y-m-d H:i:s'))->get());

        $today = Carbon::today();
        $return = EndOfDayData::storeEOD2DB($today);

        echo $return;
        return response()->json('Uploaded Successful');

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

}
