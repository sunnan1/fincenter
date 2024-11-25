<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundScrip;
use App\Models\Scrips;
use Illuminate\Http\Request;

class FundController extends Controller
{

    public function getFunds() {
        $pageTitle = 'Funds Summary';
        $funds = Fund::with('latestperformance')->get();
        return view('funds-listing', compact('pageTitle' , 'funds'));
    }
    public function addFund(){
        $pageTitle = 'Register New Fund';
        return view('add-fund', compact('pageTitle'));
    }

    public function editFund($fund){
        $pageTitle = 'Edit Fund';
        $scrips = Scrips::all();
        $fund = Fund::whereId($fund)->with('scrips.scrip')->first();
        return view('edit-fund', compact('pageTitle' , 'fund' , 'scrips'));
    }

    public function saveFundStock(Request $request){
        if ($request->has('fundid')) {
            $fund = Fund::find($request->get('fundid'));
            $fund->is_active = $request->get('active') == 'on' ? 1 : 0;
            $fund->save();
            if (! empty($request->get('percentage'))) {
                FundScrip::create([
                    'fund_id' => $request->get('fundid'),
                    'scrip_id' => $request->get('stock'),
                    'equity_per' => $request->get('percentage'),
                ]);
            }
            return redirect()->back();
        }
    }

    public function removeMapping($id){
        FundScrip::whereId($id)->delete();
        return redirect()->back();
    }

    public function showLiveFunds() {
        $pageTitle = 'ESTIMATED FUND RETURNS PER 100,000 FOR TODAY';
        $activeFunds = Fund::with('scrips.scripdata')->where('is_active', 1)->get();
        $funds = [];
        foreach ($activeFunds as $activeFund) {
            $profitLoss = 0;
            foreach ($activeFund->scrips as $scrip) {
                $profitLoss += (100000 * ($scrip->equity_per / 100) * ($scrip->scripdata->change_per / 100));
                print (100000 * ($scrip->equity_per / 100) * ($scrip->scripdata->change_per / 100)) . PHP_EOL;
            }
            dd(12312);
            $funds[] = [
                'fund' => $activeFund->name,
                'profit_loss' => $profitLoss
            ];
        }
        return view('live-fund  ', compact('funds' , 'pageTitle'));
    }
}
