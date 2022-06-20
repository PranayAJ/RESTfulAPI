<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // 1. Empty all the tables
        if (App::environment() === 'production') exit();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Truncate all tables, except migrations
        $tables = DB::select('SHOW TABLES');
        $tempAttributeName = "Tables_in_" . env('DB_DATABASE');
        foreach ($tables as $table) {
            if ($table->$tempAttributeName !== 'migrations')
                DB::table($table->$tempAttributeName)->truncate();
        }

        // 2. Seed the database using required Factory
        $numOfUsers = 200;
        $numOfCategories = 30;
        $numOfProducts = 1000;
        $numOfTransaction = 1000;

        User::factory()->count($numOfUsers)->create();
        Category::factory()->count($numOfCategories)->create();
        Product::factory()
            ->count($numOfProducts)
            ->create()
            ->each(function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
            });
        Transaction::factory()->count($numOfTransaction)->create();

    }
}
