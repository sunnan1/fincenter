<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundPerformance;
use App\Models\ScripData;
use App\Models\Sectors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index() {
        $lastUpdated = ScripData::latest('created_at')->first();
        $pageTitle = 'Stocks Summary';
        $pageDescription = '';
        $data = Sectors::whereHas('scrips.today' , $result = function ($query) use ($lastUpdated) {
            $query->where('scrip_date', $lastUpdated->scrip_date);
        })->with(['scrips.today' => $result])->get();
        return view('psx-listing', compact('lastUpdated', 'pageTitle' , 'data'));
    }
    public function funds() {
        $lastUpdated = FundPerformance::latest('created_at')->first();
        $pageTitle = 'Funds Performance';
        $pageDescription = '';
        $data = Fund::with('latestperformance')->get();
        return view('funds-listing', compact('lastUpdated', 'pageTitle' , 'data'));
    }
}
