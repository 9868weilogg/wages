<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EndOfDayData;
use App\Models\Fundamental;
use App\Models\Stock;

use App\Http\Resources\FcfYieldCollection;

class FcfYieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fcfYield = [];
        $codes = Fundamental::groupBy('code')->get()->pluck('code');
        $fyes = Fundamental::groupBy('fye')->get()->pluck('fye');

        foreach($codes as $key => $code){
          $total10YrEps = Fundamental::where('code',$code)->skip(1)->first()->eps / 100 * pow(1.1,10);
          $total10YrDps = $total10YrEps * Fundamental::where('code',$code)->avg('dy') / 100;
          $total10YrReturn = $total10YrEps + $total10YrDps;
          $estimatePrice = $total10YrEps * Fundamental::where('code',$code)->avg('pe');
          $intrinsicValue = $estimatePrice / pow(1.1,10);
          $intrinsic_25_discount = $intrinsicValue * 0.75;
          $low52week_33_premium = ((EndOfDayData::where('code',$code)->max('close') - EndOfDayData::where('code',$code)->min('close')) * 0.33) + EndOfDayData::where('code',$code)->min('close');
          $buy_price = min($intrinsic_25_discount, $low52week_33_premium);
          
          $fcfYield[$key] = [
            'name' => Stock::where('code',$code)->first()->short_name,
            'close' => EndOfDayData::where('code',$code)->latest()->first()->close,
            'low52week' => EndOfDayData::where('code',$code)->min('close'),
            'high52week' => EndOfDayData::where('code',$code)->max('close'),
            'pe' => number_format((float) Fundamental::where('code',$code)->avg('pe'), 2, '.', ''),
            'roe' => number_format((float) Fundamental::where('code',$code)->avg('roe'), 2, '.', ''),
            'dy' => number_format((float) Fundamental::where('code',$code)->avg('dy'), 2, '.', ''),
            'net_profit_gr' => number_format((float) Fundamental::where('code',$code)->avg('net_profit_gr'), 2, '.', ''),
            'buy_price' => number_format((float) $buy_price, 4, '.', ''),
            // 'total10YrEps' => $total10YrEps,
            // 'total10YrDps' => $total10YrDps,
            // 'total10YrReturn' => $total10YrReturn,
            // 'estimatePrice' => $estimatePrice,
            // 'intrinsicValue' => $intrinsicValue,
            // 'intrinsic_25_discount' => $intrinsic_25_discount,
            // 'low52week_33_premium' => $low52week_33_premium,
          ];
          foreach($fyes as $fyeKey => $fye){

            if(Fundamental::where('code',$code)->where('fye',$fye)->first()->fcf_share != 0){
              $fcf = Fundamental::where('code',$code)->where('fye',$fye)->first()->fcf_share * Fundamental::where('code',$code)->where('fye',$fye)->first()->share_qty;
              $marketCap = EndOfDayData::where('code',$code)->latest()->first()->close * Fundamental::where('code',$code)->where('fye',$fye)->first()->share_qty;
              $enterpriceValue = $marketCap + Fundamental::where('code',$code)->where('fye',$fye)->first()->short_term_loan + Fundamental::where('code',$code)->where('fye',$fye)->first()->long_term_loan - Fundamental::where('code',$code)->where('fye',$fye)->first()->total_cash;  

              $fcfYield[$key]['y'.$fye] = number_format((float) $fcf/$enterpriceValue * 100, 2, '.', '');
            } elseif(Fundamental::where('code',$code)->where('fye',$fye)->first()->fcf_share == 0){
              $fcfYield[$key]['y'.$fye] = 0;
            }
          }
        }

        $fcfCollection = collect($fcfYield);

        return new FcfYieldCollection($fcfCollection);
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
