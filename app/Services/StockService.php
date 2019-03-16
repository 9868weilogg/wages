<?php

namespace App\Services;

use App\Models\Industry;
use App\Models\Sector;
use App\Models\Stock;

use DB;
use Storage;

use App\Interfaces\CsvInterface;

class StockService implements CsvInterface {

  private $firstRow;
  private $firstColumn;
  private $shortNameColumn;
  private $sectorCodeColumn;
  private $sectorCodeColumnFromStock;
  private $sectorNameColumn;
  private $stockCodeColumn;
  private $companyNameColumn;
  private $industryCodeColumnFromStock;
  private $industryCodeColumn;
  private $industryNameColumn;

  public function __construct() {
    $this->firstRow                   = config('constants.rows.firstRow');
    $this->firstColumn                = config('constants.stockFile.columns.firstColumn');
    $this->shortNameColumn            = config('constants.stockFile.columns.shortNameColumn');
    $this->sectorCodeColumn           = config('constants.industrySectionFile.columns.sectorCodeColumn');
    $this->sectorCodeColumnFromStock  = config('constants.stockFile.columns.sectorCodeColumn');
    $this->sectorNameColumn           = config('constants.industrySectionFile.columns.sectorNameColumn');
    $this->stockCodeColumn            = config('constants.stockFile.columns.stockCodeColumn');
    $this->companyNameColumn          = config('constants.stockFile.columns.companyNameColumn');
    $this->industryCodeColumnFromStock= config('constants.stockFile.columns.industryCodeColumn');
    $this->industryCodeColumn         = config('constants.industrySectionFile.columns.industryCodeColumn');
    $this->industryNameColumn         = config('constants.industrySectionFile.columns.industryNameColumn');
  }

  public function updateStockList($request,$tableArray){
    $csvLines     = (new StockService)->retrieveCsvLines($request);
    $fileExtension= $request->file('file')->getClientOriginalExtension();

    (new StockService)->truncateTable($tableArray);
    foreach($csvLines as $key => $line) {
      if($key != $this->firstRow){
        if($fileExtension    == "txt") $data = str_getcsv($line,"|");
        elseif($fileExtension== "csv") $data = str_getcsv($line);

        if($data[$this->shortNameColumn] != null) {
          $stock            = new Stock;
          $stock->code      = $data[$this->stockCodeColumn];
          $stock->short_name= $data[$this->shortNameColumn];

          if(Sector::where('code',$data[$this->sectorCodeColumnFromStock])->first()) {
            $sectorId = Sector::where('code',$data[$this->sectorCodeColumnFromStock])->first()->id;
          } elseif(!Sector::where('code',$data[$this->sectorCodeColumnFromStock])->first()) {
            $sectorId = $data[$this->sectorCodeColumnFromStock];
          }

          $stock->sector_id= $sectorId;
          $stock->name     = $data[$this->companyNameColumn];

          if(count($data) == 15){
            if(Industry::where('code',$data[$this->industryCodeColumnFromStock])->first()) {
              $industryId = Industry::where('code',$data[$this->industryCodeColumnFromStock])->first()->id;
            }
            elseif(!Industry::where('code',$data[$this->industryCodeColumnFromStock])->first()) {
              $industryId = 0;
            }
          } else {
            $industryId = 0;
          }
          
          $stock->industry_id = $industryId;
          $stock->save();
        }
      }
    }
    return true;
  }

  public function updateSectorIndustry($request, $tableArray) {
    $csvLines = (new StockService)->retrieveCsvLines($request);
    $fileExtension = $request->file('file')->getClientOriginalExtension();

    (new StockService)->truncateTable($tableArray);
    $range = (new StockService)->getTableRange($csvLines);

    foreach($csvLines as $key => $line) {
      if($fileExtension    == "txt") $data = str_getcsv($line,"=");
      elseif($fileExtension== "csv") $data = str_getcsv($line);

      if($key >= $range['sectorStartKey'] && $key <= $range['sectorEndKey']) {
        $sector      = new Sector;
        $sector->code= $data[$this->sectorCodeColumn]; 
        $sector->name= utf8_encode($data[$this->sectorNameColumn]); 
        $sector->save();

      } elseif($key >= $range['industryStartKey'] && $key <= $range['industryEndKey']) {
        $industry      = new Industry;
        $industry->code= $data[$this->industryCodeColumn]; 
        $industry->name= utf8_encode($data[$this->industryNameColumn]); 
        $industry->save();
      }
    }
    return true;
  }

  private function getTableRange($csvLines){
    foreach($csvLines as $key => $line) {

      $data = str_getcsv($line);
      if($data[$this->firstColumn]== "[Sector_KL]")    $range['sectorStartKey']   = $key + 1;
      if($data[$this->firstColumn]== "[Industry_KL]")  $range['industryStartKey'] = $key + 1;
      if($data[$this->firstColumn]== "[Market_KL]")    $range['sectorEndKey']     = $key - 2;
      if($data[$this->firstColumn]== "[Fundamental]")  $range['industryEndKey']   = $key - 2;
    }

    return $range;
  }

  public function retrieveCsvLines($request) {
    $path = $request->file('file')->storeAs(
      'stocks', $request->filename
    );

    $csvFile = Storage::get($path);
    $csvLines = str_getcsv($csvFile, "\n");

    return $csvLines;
  }

  private function truncateTable($tableArray){
    foreach($tableArray as $table){
      DB::table($table)->truncate();
    }
  }

}