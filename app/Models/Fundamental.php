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
}
