<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Stock extends Model
{
    protected $fillable = [
      'code',
      'name',
      'short_name',
      'sector_id',
      'industry_id',
    ];

    public function sector(){
      return $this->belongsTo('App\Models\Sector');
    }

    public function industry(){
      return $this->belongsTo('App\Models\Industry');
    }

    public static function getStockWithoutDerivative(){
      return Stock::with('sector','industry')->where('industry_id','!=','0')->get();
    }
}
