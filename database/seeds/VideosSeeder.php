<?php

use App\Video;
use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::whereNotNull('id')->delete();

        Video::firstOrCreate([
            'id'     => 1,
            'url'    => 'https://www.youtube.com/watch?v=COxQooD4Jfk',
            'page'   => 'agency',
            'status' => 1
        ]);

        Video::firstOrCreate([
            'id'     => 2,
            'url'    => 'https://www.youtube.com/watch?v=EgVltIVMbvw',
            'page'   => 'trade-services',
            'status' => 1
        ]);

        Video::firstOrCreate([
            'id'     => 3,
            'url'    => 'https://www.youtube.com/watch?v=AjR5Y0oY7P8',
            'page'   => 'customer',
            'status' => 1
        ]);
    }
}
