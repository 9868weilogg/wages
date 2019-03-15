<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GisRank extends Model
{
    protected $fillable = [
      'code',
      'ba1',
      'ba1_1',
      'ba1_2',
      'ba1_3',
      'ba1_4',
      'ba1_5',
      'ba2',
      'ba3',
      'ba4',
      'ba5',
      'ba6',
      'ba7',
      'fa1',
      'fa2',
      'fa3',
      'fa4',
      'fa5',
      'fa6',
      'fa7',
      'buffett_mark',
      'fisher_mark',
      'watchlist_item_id',
    ];
}
