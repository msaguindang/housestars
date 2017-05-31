<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UserMetaMultipleCategoriesChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'housestars:change-trade-meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to change previous "trade" meta from category name to category id';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "\nUPDATING ... \n";
        $tradeMetas = DB::table('user_meta')->where('meta_name', 'trade')->get();
        foreach ($tradeMetas as $tradeMeta) {
            if ($categoryObj = DB::table('categories')->where('category', $tradeMeta->meta_value)->first()) {
                DB::table('user_meta')->where('id', $tradeMeta->id)->update(['meta_value' => $categoryObj->id]);
                echo "*";
            }
        }
        echo "\nDONE!\n";
    }
}
