<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run() {
        $this->call(AdminSeeder::class);
    }
}
