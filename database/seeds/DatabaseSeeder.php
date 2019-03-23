<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = [

      'watchlists',
      'watchlist_items',
      'users',
      'plans',

    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->toTruncate as $table) {
        DB::table($table)->truncate();
      }

      $this->call([
        WatchlistsTableSeeder::class,
        WatchlistItemsTableSeeder::class,
        UsersTableSeeder::class,
        PlansTableSeeder::class,
      ]);
    }
}
