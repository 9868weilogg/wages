<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchlistItem extends Model
{
    protected $fillable = [
      'watchlist_id',
      'code',
    ];

    public function watchlist(){
      return $this->belongsTo('App\Models\Watchlist');
    }

}
