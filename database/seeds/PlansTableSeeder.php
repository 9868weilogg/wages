<?php

use Illuminate\Database\Seeder;

use App\Models\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
      $item = new Plan;
      $item->name = "Basic";
      $item->slug = "basic";
      $item->braintree_plan = "Basic";
      $item->cost = 10.00;
      $item->description = "This is a basic subscription plan worth of 10$";
      $item->save();

      $item = new Plan;
      $item->name = "Professional";
      $item->slug = "professional";
      $item->braintree_plan = "Professional";
      $item->cost = 50.00;
      $item->description = "This is a professional subscription plan worth of 50$";
      $item->save();
    }
}
