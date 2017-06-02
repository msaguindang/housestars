<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google;
use Sheets;

class FaqController extends Controller
{
    public function customer()
    {

        Sheets::setService(Google::make('sheets'));
        // Sheets::spreadsheet('1CQdK1a2CJErV_MdG66alhzOewHgRiVUr6q4ltFo16eU');
        Sheets::spreadsheet('15R5tZn0AvZC_x3hcZeL2dO1vRU9enQKnU8nT-tsl_jA');

        $values = Sheets::sheet('customer')->all();

        return view('general.faq-customer')->with('data', $values);
    }
    
    public function agency()
    {

        Sheets::setService(Google::make('sheets'));
        // Sheets::spreadsheet('1CQdK1a2CJErV_MdG66alhzOewHgRiVUr6q4ltFo16eU');
        Sheets::spreadsheet('15R5tZn0AvZC_x3hcZeL2dO1vRU9enQKnU8nT-tsl_jA');

        $values = Sheets::sheet('agency')->all();

        return view('general.faq-agency')->with('data', $values);
    }
    
    public function tradesman()
    {

        Sheets::setService(Google::make('sheets'));
        // Sheets::spreadsheet('1CQdK1a2CJErV_MdG66alhzOewHgRiVUr6q4ltFo16eU');
        Sheets::spreadsheet('15R5tZn0AvZC_x3hcZeL2dO1vRU9enQKnU8nT-tsl_jA');

        $values = Sheets::sheet('tradesman')->all();

        return view('general.faq-tradesman')->with('data', $values);
    }
}
