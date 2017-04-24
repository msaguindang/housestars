<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google;

class TestingController extends Controller
{
    public function index()
    {
        //$googleClient = Google::getClient();
        $sheets = Google::make('sheets');

        $range = 'A:E';
        $test = $sheets->spreadsheets_values->get('1CQdK1a2CJErV_MdG66alhzOewHgRiVUr6q4ltFo16eU', $range);

        dump($test);

        // list buckets example
        //$storage->buckets->listBuckets('test_project');

        // get object example
        //$storage->objects->get('bucket', 'object');
    }
}
