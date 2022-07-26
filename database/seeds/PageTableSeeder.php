<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['About Us', 'Privacy Policy', 'Terms & condition', 'Help' ];
        DB::table('pages')->delete();

        for ($i=0; $i < count($pages); $i++) {

            \App\Pages::factory()->create([
                'page_title' => $pages[$i],
                'page_slug' => str_replace(' ', '-', strtolower($pages[$i])),
            ]);

        }
    }
}
