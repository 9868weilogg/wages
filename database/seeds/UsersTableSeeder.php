<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
      $item = new User;
      $item->name = "Weilogg";
      $item->email = "weilogg@mail.com";
      $item->password = bcrypt(123456);
      $item->save();
    }
}
