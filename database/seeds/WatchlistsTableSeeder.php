<?php

use Illuminate\Database\Seeder;

use App\Models\Watchlist;

class WatchlistsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
      $watchlist = new Watchlist;
      $watchlist->name = "Watchlist 1";
      $watchlist->user_id = 1;
      $watchlist->save();
    }
}
