<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fundamental;
use App\Models\Stock;

use App\Http\Resources\FundamentalCollection;

use App\Services\FundamentalService;

class FundamentalsController extends Controller
{
    public function __construct(
      FundamentalService $fundamentalService, 
      Fundamental $fundamental, 
      Stock $stock) {

      $this->fundamentalService = $fundamentalService;
      $this->fundamental = $fundamental;
      $this->stock = $stock;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fundamentals = $this->fundamental->get();
        foreach($fundamentals as $fundamental){
          $stockName = $this->stock->where('code',$fundamental->code)->first()->short_name;
          $fundamental->name = $stockName;
        }
     
        return new FundamentalCollection($fundamentals);
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
        if($request->process == "upload_fundamental_data") {
          if($request->hasFile('file') ){

            $uploaded = $this->fundamentalService->updateFundamentalData($request);

            if($uploaded) $response = "Update Fundamental Data Successfully";
            elseif(!$uploaded) $response = "Failed Update Fundamental Data";
            

          } else {
            $response = "Failed Update Fundamental Data";

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
