<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
