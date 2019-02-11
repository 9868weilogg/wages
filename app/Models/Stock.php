<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;
use DB;

class Stock extends Model
{
    protected $fillable = [
      'code',
      'name',
      'short_name',
      'sector_id',
      'industry_id',
    ];

    public static function retrieveCsvLines($request) {
      $path = $request->file('file')->storeAs(
        'stocks', $request->filename
      );

      $csvFile = Storage::get($path);
      $csvLines = str_getcsv($csvFile, "\n");

      return $csvLines;
    }

    public static function getTableRange($csvLines){
      foreach($csvLines as $key => $line) {

        $data = str_getcsv($line);
        if($data[0] == "[Sector_KL]") $range['sectorStartKey'] = $key + 1;
        if($data[0] == "[Industry_KL]") $range['industryStartKey'] = $key + 1;
        if($data[0] == "[Market_KL]") $range['sectorEndKey'] = $key - 2;
        if($data[0] == "[Fundamental]") $range['industryEndKey'] = $key - 2;
      }

      return $range;
    }

    public static function truncateTable($tableArray){
      foreach($tableArray as $table){
        DB::table($table)->truncate();
      }
    }

    public static function updateStockList($request,$tableArray){
      $csvLines = Stock::retrieveCsvLines($request);
      Stock::truncateTable($tableArray);

      foreach($csvLines as $key => $line) {
        if($key != 0){
          $data = str_getcsv($line);
          if($data[1] != null) {
            $stock = new Stock;
            $stock->code = $data[0];
            $stock->short_name = $data[1];

            if(Sector::where('code',$data[2])->first()) $sectorId = Sector::where('code',$data[2])->first()->id;
            elseif(!Sector::where('code',$data[2])->first()) $sectorId = $data[2];

            $stock->sector_id = $sectorId;
            $stock->name = $data[4];

            if(Industry::where('code',$data[14])->first()) $industryId = Industry::where('code',$data[14])->first()->id;
            elseif(!Industry::where('code',$data[14])->first()) $industryId = 0;

            $stock->industry_id = $industryId;
            $stock->save();

          }
          
        }
      }
    }

    public static function updateSectorIndustry($request, $tableArray) {
      $csvLines = Stock::retrieveCsvLines($request);
      Stock::truncateTable($tableArray);
      $range = Stock::getTableRange($csvLines);

      foreach($csvLines as $key => $line) {

        $data = str_getcsv($line);

        if($key >= $range['sectorStartKey'] && $key <= $range['sectorEndKey']) {
          $sector = new Sector;
          $sector->code = $data[0]; 
          $sector->name = utf8_encode($data[1]); 
          $sector->save();

        } elseif($key >= $range['industryStartKey'] && $key <= $range['industryEndKey']) {
          $industry = new Industry;
          $industry->code = $data[0]; 
          $industry->name = utf8_encode($data[1]); 
          $industry->save();

        }
          

      }
    }
}
