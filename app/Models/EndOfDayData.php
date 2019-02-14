<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class EndOfDayData extends Model
{
    protected $fillable = [
      'code',
      'volume',
      'close',
      'open',
      'high',
      'low',
      'high52wk',
      'low52wk',
      'market_cap',
      'created_at',
    ];

    public static function crawlKlseScreenerForEOD(){
      $path = public_path('asset/simplehtmldom_1_7/simple_html_dom.php');
      include($path);

      // $stocks = Stock::all();
      $recordedEOD = EndOfDayData::whereDate('created_at',Carbon::today())->get()->pluck('code');
      // dd($recordedEOD);
      $stocks = Stock::where('industry_id','!=','0')->whereNotIn('code',$recordedEOD)->get();
      // dd($stocks);
      foreach($stocks as $stock) {
        $stock_id = $stock->code;
        $url = 'http://www.klsescreener.com/v2/stocks/view/'.$stock_id;
        $html = file_get_html($url);
        foreach ($html->find('span') as  $span) {
          if($span->getAttribute('id') == 'price'){
              $cp = filter_var($span,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
              $current_price = (double) $cp;
          }
          if($span->getAttribute('id') == 'priceDiff'){
              $diff = explode("(",$span);
              $pd = filter_var($diff[0],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
              $price_diff = (double) $pd;
          }
            
        }

        foreach ($html->find('td') as  $td) {
            if($td->getAttribute('id') == 'priceHigh'){
                $ph = filter_var($td,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $price_high = (double) $ph;
            }
            if($td->getAttribute('id') == 'priceLow'){
                $pl = filter_var($td,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $price_low = (double) $pl;
            }
            if($td->getAttribute('id') == 'volume'){
                $v = filter_var($td,FILTER_SANITIZE_NUMBER_INT);
                $volume = (double) $v;
                
            }
        }
        if($html->find('td',12)->innertext == "52w") $week52_range = explode('-', $html->find('td',13)->innertext);
        if($week52_range) $low_52week = trim($week52_range[0]," ");
        if($week52_range) $high_52week = trim($week52_range[1]," ");
        // if($html->find('td',14)->innertext == "ROE") {
        //   $roe = $html->find('td',15)->innertext;
        //   $roe = str_replace(",","",$roe);
        //   if(!$roe) $roe = 0;
        // }
        // if($html->find('td',16)->innertext == "P/E") {
        //   $pe = $html->find('td',17)->innertext;
        //   $pe = str_replace(",","",$pe);
        //   if(!$pe) $pe = 0;
        // }
        // if($html->find('td',18)->innertext == "EPS") {
        //   $eps = $html->find('td',19)->innertext;
        //   $eps = str_replace(",","",$eps);
        //   if(!$eps) $eps = 0;
        // }
        // if($html->find('td',20)->innertext == "DPS") {
        //   $dps = $html->find('td',21)->innertext;
        //   $dps = str_replace(",","",$dps);
        //   if(!$dps) $dps = 0;
        // }
        // if($html->find('td',22)->innertext == "DY") {
        //   $dy = trim($html->find('td',23)->innertext,"%");
        //   $dy = str_replace(",","",$dy);
        //   if(!$dy) $dy = 0;
        // }
        if($html->find('td',32)->innertext == "Market Cap") $mc = trim($html->find('td',33)->innertext,"M");
        if($mc) $market_cap = str_replace(",","",$mc);
        $open_price = $current_price + $price_diff;

        EndOfDayData::create([
          'code' => $stock_id,
          'high' => $price_high,
          'low' => $price_low,
          'close' => $current_price,
          'open' => $open_price,
          'volume' => $volume,
          'high52wk' => $high_52week,
          'low52wk' => $low_52week,
          'market_cap' => $market_cap,
        ]);
        $html->clear();
      }
      return response()->json('get quote success');
    }

    public static function uploadFrom2018(){
      ini_set('max_execution_time', 0); // for infinite time of execution 

      $from = Carbon::createFromDate(2018, 1, 2);
      $to = Carbon::createFromDate(2019, 2, 10);

      for($date = $from; $date->lte($to); $date->addDay()) {

        EndOfDayData::storeEOD2DB($date);
        
      }
    }

    public static function storeEOD2DB($date){
      ini_set('max_execution_time', 0); // for infinite time of execution 
      $dateTxt = $date->format('Ymd');
      
      $exist = count(EndOfDayData::where('created_at',">=",Carbon::today()->format('Y-m-d H:i:s'))->where('created_at','<',Carbon::today()->addDay()->format('Y-m-d H:i:s'))->get());  

      if($exist == 0) {
        $file_url = 'http://www.free88.org/free88trigger/DownloadFile.aspx?Exchange=KLSE&Filename=KLSE_' . $dateTxt . '.txt';

        $data = file_get_contents($file_url);
        $csvLines = str_getcsv($data,"\r\n");


        if(!str_contains(str_getcsv($csvLines[0])[0],"Could not find file")) {
          foreach($csvLines as $key => $line){
            $data = str_getcsv($line);

            if(!is_null($line) && str_contains($line,".KL") && $data[3] == $dateTxt){
              if(Stock::where('short_name',trim($data[1],".KL"))->where('industry_id','!=',0)->first()){
                EndOfDayData::create([
                  'open' => $data[4],
                  'high' => $data[5],
                  'low' => $data[6],
                  'close' => $data[7],
                  'volume' => $data[8],
                  'code' => Stock::where('short_name',trim($data[1],".KL"))->first()->code,
                  'created_at' => Carbon::createFromFormat('Ymd', $dateTxt)->timestamp,
                ]);

              } elseif(!Stock::where('short_name',trim($data[1],".KL"))->first()) {
                if(str_contains($data[0],".KL")){
                  EndOfDayData::create([
                    'open' => $data[4],
                    'high' => $data[5],
                    'low' => $data[6],
                    'close' => $data[7],
                    'volume' => $data[8],
                    'code' => substr($data[0],count($data[0])-9,count($data[0])-5),
                    'created_at' => Carbon::createFromFormat('Ymd', $dateTxt)->timestamp,
                  ]);

                } 
                else {
                  EndOfDayData::create([
                    'open' => $data[4],
                    'high' => $data[5],
                    'low' => $data[6],
                    'close' => $data[7],
                    'volume' => $data[8],
                    'code' => $data[1],
                    'created_at' => Carbon::createFromFormat('Ymd', $dateTxt)->timestamp,
                  ]);

                }
              }
            } 
          }
        }
        return "Store Success.";
      } else {
        return  "Store Failed.";
      }
    }
}
