<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use UserMeta;

class Referral extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:referral';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check trademans referral';

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
      UserMeta::updateOrCreate(
          ['user_id' => 0, 'meta_name' => 'test'],
          ['user_id' => 0, 'meta_name' => 'test', 'meta_value' => 'YES']
      );
    }
}
