<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock;

use App\Http\Resources\StockCollection;

use App\Services\StockService;

class StocksController extends Controller
{
    private $stockService;
    private $stock;

    public function __construct(StockService $stockService, Stock $stock) {
      $this->stockService = $stockService;
      $this->stock = $stock;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $stocks = $this->stock->getStockWithoutDerivative();
     
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

            $uploaded = $this->stockService->updateStockList($request,['stocks']);

            if($uploaded) $response = "Update Stock List Successfully";
            elseif(!$uploaded) $response = "Failed Update Stock List";
            

          } else {
            $response = "Failed Update Stock List";

          }
        } elseif($request->process == "upload_sector_industry_code") {
          if($request->hasFile('file') ){
            
            $uploaded = $this->stockService->updateSectorIndustry($request,['sectors','industries']);

            if($uploaded) $response = "Update Sector and Industry Successfully";
            elseif(!$uploaded) $response = "Failed Update Sector and Industry";

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
