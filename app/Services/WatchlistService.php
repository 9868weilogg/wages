<?php

namespace App\Services;

use App\Models\Watchlist;

class WatchlistService {
  public function __construct(Watchlist $watchlist) {
    $this->watchlist = $watchlist;
  }

  public function create($request) {
    $watchlist = $this->watchlist->create([
      'name' => $request->watchlist,
      'user_id' => 1,
    ]);
    return true;
  }
}