<?php

use App\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call();

        // factory(App\Category::class,5)->create();
        factory(Product::class,5)->create();
        factory(App\Admin::class,1)->create();
        factory(App\User::class,5)->create();
        # For create pages
        $pages = ['About Us', 'Privacy Policy', 'Terms & condition', 'Help'];
        for ($i=0; $i < count($pages); $i++) {
            factory(App\Pages::class)->create([
                'page_title' => $pages[$i],
                'page_slug' => str_replace(strtolower($pages[$i]), ' ', '-') ,
            ]);
        }
        # Call database seeder to add countries,state,city data
        $this->call(CountriesTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}
