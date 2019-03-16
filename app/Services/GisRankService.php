<?php

namespace App\Services;

use App\Models\GisRank;
use App\Http\Resources\GisRankCollection;

class GisRankService {

  

  public function __construct(GisRank $gisRank) {
    $this->gisRank = $gisRank;
  }

  public function checkIfExist($request) {
    if($request->get == "checkIfExist") {
      $watchlistItemRank = $this->gisRank->where('watchlist_item_id', $request->watchlist_item_id)->first();
      if($watchlistItemRank) return $watchlistItemRank;
      else return false;
    }
  }

  public function create($request) {
    $watchlistItem = $this->gisRank->create([
      'code' => $request->code,
      'watchlist_item_id' => $request->watchlist_item_id,
    ]);

    return true;
  }

  public function update($request, $id) {
    $watchlistItem = $this->gisRank->where('watchlist_item_id',$id)->first();
    $watchlistItem->update([
      $request->key => $request->value,
    ]);

    return true;
  }

}