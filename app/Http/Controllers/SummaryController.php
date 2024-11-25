<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundPerformance;
use App\Models\ScripData;
use App\Models\Scrips;
use App\Models\Sectors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index() {
        $pageTitle = 'Stocks Summary';
        $data = Scrips::with('latest')->get();
        return view('psx-listing', compact('pageTitle' , 'data'));
    }
}
