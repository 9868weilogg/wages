<?php

use Illuminate\Database\Seeder;

use App\Models\WatchlistItem;

class WatchlistItemsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
      $item = new WatchlistItem;
      $item->code = "1155";
      $item->watchlist_id = 1;
      $item->save();
    }
}
