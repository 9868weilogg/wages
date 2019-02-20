<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\EndOfDayData;
use App\Models\Industry;
use App\Models\Sector;
use App\Models\Stock;

use App\Http\Resources\StockCollection;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $stocks = Stock::with('sector','industry')->where('industry_id','!=','0')->get();
     
        return new StockCollection($stocks);
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
        if($request->process == "upload_bursa_stock_list") {
          if($request->hasFile('file') ){

            Stock::updateStockList($request,['stocks']);

            $response = "Update Stock List Successfully";
            

          } else {
            $response = "Failed Update Stock List";

          }
        } elseif($request->process == "upload_sector_industry_code") {
          if($request->hasFile('file') ){
            
            Stock::updateSectorIndustry($request,['sectors','industries']);

            $response = "Update Sector and Industry Successfully";

          } else {
            $response = "Failed Update Sector and Industry";

          } 
        }
        return response()->json($response);
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
          // return response()->json('a');
        return response()->json($request);

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
