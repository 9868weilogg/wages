<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;

class Fundamental extends Model
{
    protected $fillable = [
      'code',
      'fye',
      'pe',
      'dy',
      'eps',
      'dps',
      'net_profit_gr',
      'share_qty',
      'total_cash',
      'short_term_loan',
      'long_term_loan',
      'gearing',
      'debt_equity',
      'gp_cash',
      'net_margin',
      'roe',
      'fcf_share',
      'roa',
    ];

    public static function retrieveCsvLines($file){
      $path = $file->storeAs(
        'fundamentals', $file->getClientOriginalName()
      );

      $csvFile = Storage::get($path);
      $csvLines = str_getcsv($csvFile, "\n");

      return $csvLines;
    }

    public static function deleteExistingRecords($code){
      foreach(Fundamental::where('code',str_pad($code, 4, '0', STR_PAD_LEFT))->get() as $delete){
        $delete->delete();
      }
    }

    public static function processCsvLines($csvLines){
      $data = [];
      foreach($csvLines as $key => $line) {
        $data[] = str_getcsv($line);
      }

      return $data;
    }

    public static function updateFundamentalData($request){
      foreach($request->file('file') as $file){
        $csvLines = Fundamental::retrieveCsvLines($file);
        
        $data = Fundamental::processCsvLines($csvLines);
        
        $fundamental_data = Fundamental::extractFundamentalData($data);

        Fundamental::deleteExistingRecords($data[0][2]);
        
        foreach($fundamental_data['fye'] as $key => $fye){
          
          Fundamental::create([
            'code' => str_pad($data[0][2], 4, '0', STR_PAD_LEFT),
            'fye' => $fundamental_data['fye'][$key],
            'pe' => $fundamental_data['pe'][$key],
            'dy' => $fundamental_data['dy'][$key],
            'eps' => $fundamental_data['eps'][$key],
            'dps' => $fundamental_data['dps'][$key],
            'net_profit_gr' => $fundamental_data['net_profit_gr'][$key],
            'share_qty' => $fundamental_data['share_qty'][$key],
            'total_cash' => $fundamental_data['total_cash'][$key],
            'short_term_loan' => $fundamental_data['short_term_loan'][$key],
            'long_term_loan' => $fundamental_data['long_term_loan'][$key],
            'gearing' => $fundamental_data['gearing'][$key],
            'debt_equity' => $fundamental_data['debt_equity'][$key],
            'gp_cash' => $fundamental_data['gp_cash'][$key],
            'net_margin' => $fundamental_data['net_margin'][$key],
            'roe' => $fundamental_data['roe'][$key],
            'fcf_share' => $fundamental_data['fcf_share'][$key],
          ]);
        }
      }
    }

    public static function extractFundamentalData($data){
      foreach($data as $lkey => $lines) {
        foreach($lines as $dkey => $d) {
          if($dkey >= "12") {
            if($lkey == "0") {
              $FYE[] = $d;
            }

            if($lkey == "1") {
              $PE[] = $d;
            }

            if($lkey == "2") {
              $DY[] = $d;
            }

            if($lkey == "3") {
              $EPS[] = $d;
            }

            if($lkey == "4") {
              $DPS[] = $d;
            }

            if($lkey == "5") {
              $net_profit_gr[] = $d;
            }

            if($lkey == "6") {
              $roe[] = $d;
            }

            if($lkey == "7") {
              $debt_equity[] = $d;
            }

            if($lkey == "8") {
              $net_margin[] = $d;
            }

            if($lkey == "9") {
              $gearing[] = $d;
            }

            if($lkey == "10") {
              $share_qty[] = $d;
            }

            if($lkey == "11") {
              $FCF_per_share[] = $d;
            }

            if($lkey == "12") {
              $short_loan[] = $d;
            }

            if($lkey == "13") {
              $long_loan[] = $d;
            }

            if($lkey == "14") {
              $total_cash[] = $d;
            }

            if($lkey == "15") {
              $gp_cash[] = $d;
            }
          }
        }
      }

      return [
        'gp_cash' => $gp_cash,
        'total_cash' => $total_cash,
        'long_term_loan' => $long_loan,
        'short_term_loan' => $short_loan,
        'fcf_share' => $FCF_per_share,
        'share_qty' => $share_qty,
        'gearing' => $gearing,
        'net_margin' => $net_margin,
        'debt_equity' => $debt_equity,
        'roe' => $roe,
        'net_profit_gr' => $net_profit_gr,
        'dps' => $DPS,
        'eps' => $EPS,
        'dy' => $DY,
        'pe' => $PE,
        'fye' => $FYE,
      ];
    }
}
