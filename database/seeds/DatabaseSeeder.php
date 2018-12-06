<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\UserController;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserController::create_admin('admin', '1', 1);
    }
}
