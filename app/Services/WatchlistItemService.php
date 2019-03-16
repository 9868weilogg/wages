<?php

namespace App\Services;

use App\Models\WatchlistItem;

class WatchlistItemService {
  public function __construct(WatchlistItem $watchlistItem) {
    $this->watchlistItem = $watchlistItem;
  }

  public function create($request) {
    $item = $this->watchlistItem->firstOrCreate([
      'code' => $request->stockCode,
      'watchlist_id' => $request->watchlistId,
    ]);
    return true;
  }

  public function delete($id) {
    $item = $this->watchlistItem->find($id)->delete();

    return true;
  }
}