<?php

namespace App\Services;

use App\Interfaces\CsvInterface;

use Storage;

use App\Models\Fundamental;

class FundamentalService implements CsvInterface {
  private $fyeRow;
  private $peRow;
  private $dyRow;
  private $epsRow;
  private $dpsRow;
  private $netProfitGrRow;
  private $roeRow;
  private $debtEquityRow;
  private $netMarginRow;
  private $gearingRow;
  private $shareQtyRow;
  private $fcfShareRow;
  private $shortTermLoanRow;
  private $longTermLoanRow;
  private $totalCashRow;
  private $gpCashRow;
  private $firstRow;
  private $fundamentalStartColumn;
  private $thirdColumn;

  public function __construct() {
    $this->fyeRow                = config('constants.fundamentalFile.rows.fyeRow');
    $this->peRow                 = config('constants.fundamentalFile.rows.peRow');
    $this->dyRow                 = config('constants.fundamentalFile.rows.dyRow');
    $this->epsRow                = config('constants.fundamentalFile.rows.epsRow');
    $this->dpsRow                = config('constants.fundamentalFile.rows.dpsRow');
    $this->netProfitGrRow        = config('constants.fundamentalFile.rows.netProfitGrRow');
    $this->roeRow                = config('constants.fundamentalFile.rows.roeRow');
    $this->debtEquityRow         = config('constants.fundamentalFile.rows.debtEquityRow');
    $this->netMarginRow          = config('constants.fundamentalFile.rows.netMarginRow');
    $this->gearingRow            = config('constants.fundamentalFile.rows.gearingRow');
    $this->shareQtyRow           = config('constants.fundamentalFile.rows.shareQtyRow');
    $this->fcfShareRow           = config('constants.fundamentalFile.rows.fcfShareRow');
    $this->shortTermLoanRow      = config('constants.fundamentalFile.rows.shortTermLoanRow');
    $this->longTermLoanRow       = config('constants.fundamentalFile.rows.longTermLoanRow');
    $this->totalCashRow          = config('constants.fundamentalFile.rows.totalCashRow');
    $this->gpCashRow             = config('constants.fundamentalFile.rows.gpCashRow');
    $this->firstRow              = config('constants.fundamentalFile.rows.firstRow');
    $this->fundamentalStartColumn= config('constants.fundamentalFile.columns.fundamentalStartColumn');
    $this->thirdColumn           = config('constants.fundamentalFile.columns.thirdColumn');
  }

  public function updateFundamentalData($request){
    foreach($request->file('file') as $file){
      $csvLines = (new FundamentalService)->retrieveCsvLines($file);
      
      $data = (new FundamentalService)->processCsvLines($csvLines);
      
      $fundamental_data = (new FundamentalService)->extractFundamentalData($data);

      (new FundamentalService)->deleteExistingRecords($data[0][2]);
      
      foreach($fundamental_data['fye'] as $key => $fye){
        
        Fundamental::create([
          'code'           => str_pad($data[$this->firstRow][$this->thirdColumn], 4, '0', STR_PAD_LEFT),
          'fye'            => $fundamental_data['fye'][$key],
          'pe'             => $fundamental_data['pe'][$key],
          'dy'             => $fundamental_data['dy'][$key],
          'eps'            => $fundamental_data['eps'][$key],
          'dps'            => $fundamental_data['dps'][$key],
          'net_profit_gr'  => $fundamental_data['net_profit_gr'][$key],
          'share_qty'      => $fundamental_data['share_qty'][$key],
          'total_cash'     => $fundamental_data['total_cash'][$key],
          'short_term_loan'=> $fundamental_data['short_term_loan'][$key],
          'long_term_loan' => $fundamental_data['long_term_loan'][$key],
          'gearing'        => $fundamental_data['gearing'][$key],
          'debt_equity'    => $fundamental_data['debt_equity'][$key],
          'gp_cash'        => $fundamental_data['gp_cash'][$key],
          'net_margin'     => $fundamental_data['net_margin'][$key],
          'roe'            => $fundamental_data['roe'][$key],
          'fcf_share'      => $fundamental_data['fcf_share'][$key],
        ]);
      }
    }
    return true;
  }

  public function retrieveCsvLines($file){
    $path = $file->storeAs(
      'fundamentals', $file->getClientOriginalName()
    );

    $csvFile = Storage::get($path);
    $csvLines = str_getcsv($csvFile, "\n");

    return $csvLines;
  }

  private function processCsvLines($csvLines){
    $data = [];
    foreach($csvLines as $key => $line) {
      $data[] = str_getcsv($line);
    }

    return $data;
  }

  private function extractFundamentalData($data){
    foreach($data as $lkey => $lines) {
      foreach($lines as $dkey => $d) {
        if($dkey >= $this->fundamentalStartColumn) {
          if($lkey == $this->fyeRow) {
            $FYE[] = $d;
          }

          if($lkey == $this->peRow) {
            $PE[] = $d;
          }

          if($lkey == $this->dyRow) {
            $DY[] = $d;
          }

          if($lkey == $this->epsRow) {
            $EPS[] = $d;
          }

          if($lkey == $this->dpsRow) {
            $DPS[] = $d;
          }

          if($lkey == $this->netProfitGrRow) {
            $net_profit_gr[] = $d;
          }

          if($lkey == $this->roeRow) {
            $roe[] = $d;
          }

          if($lkey == $this->debtEquityRow) {
            $debt_equity[] = $d;
          }

          if($lkey == $this->netMarginRow) {
            $net_margin[] = $d;
          }

          if($lkey == $this->gearingRow) {
            $gearing[] = $d;
          }

          if($lkey == $this->shareQtyRow) {
            $share_qty[] = $d;
          }

          if($lkey == $this->fcfShareRow) {
            $FCF_per_share[] = $d;
          }

          if($lkey == $this->shortTermLoanRow) {
            $short_loan[] = $d;
          }

          if($lkey == $this->longTermLoanRow) {
            $long_loan[] = $d;
          }

          if($lkey == $this->totalCashRow) {
            $total_cash[] = $d;
          }

          if($lkey == $this->gpCashRow) {
            $gp_cash[] = $d;
          }
        }
      }
    }

    return [
      'gp_cash'        => $gp_cash,
      'total_cash'     => $total_cash,
      'long_term_loan' => $long_loan,
      'short_term_loan'=> $short_loan,
      'fcf_share'      => $FCF_per_share,
      'share_qty'      => $share_qty,
      'gearing'        => $gearing,
      'net_margin'     => $net_margin,
      'debt_equity'    => $debt_equity,
      'roe'            => $roe,
      'net_profit_gr'  => $net_profit_gr,
      'dps'            => $DPS,
      'eps'            => $EPS,
      'dy'             => $DY,
      'pe'             => $PE,
      'fye'            => $FYE,
    ];
  }

  private function deleteExistingRecords($code){
    foreach(Fundamental::where('code',str_pad($code, 4, '0', STR_PAD_LEFT))->get() as $delete){
      $delete->delete();
    }
  }

}