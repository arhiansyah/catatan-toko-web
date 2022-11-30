<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'admin store nugasoma',
            'user_id' => 1
        ]);
        Store::create([
            'name' => 'store nugasoma',
            'admin_id' => $admin->id
        ]);
    }
}
