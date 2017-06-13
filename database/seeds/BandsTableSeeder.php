<?php

use Illuminate\Database\Seeder;

class BandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Band::class, 20)->create()->each(function ($band) {
            $band->albums()->saveMany(factory(App\Album::class, 5)->make());
        });
    }
}
