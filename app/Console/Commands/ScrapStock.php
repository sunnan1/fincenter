<?php

namespace App\Console\Commands;

use App\Models\ScripData;
use App\Models\Scrips;
use App\Models\Sectors;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\Browsershot\Browsershot;

class ScrapStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scraps The Stocks from Investing.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $page = 0;
        $stocks = 100;
        try {
            do{
                $res = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:132.0) Gecko/20100101 Firefox/132.0',
                    'Accept' => '*/*',
                    'Accept-Language' => 'en-US,en;q=0.5',
                    'Accept-Encoding' => 'gzip, deflate, br, zstd',
                    'Referer' => 'https://www.investing.com/',
                    'content-type' => 'application/json',
                    'domain-id' => 'www',
                    'Origin' => 'https://www.investing.com',
                    'Connection' => 'keep-alive',
                    'Sec-Fetch-Dest' => 'empty',
                    'Sec-Fetch-Mode' => 'cors',
                    'Sec-Fetch-Site' => 'same-site',
                    'Sec-GPC' => 1,
                    'Priority' => 'u=0',
                    'TE' => 'trailers',
                ])
                ->get('https://api.investing.com/api/financialdata/assets/equitiesByCountry/default', [
                    'fields-list' => 'id,name,symbol,isCFD,high,low,last,lastPairDecimal,change,changePercent,volume,time,isOpen,url,flag,countryNameTranslated,exchangeId,performanceDay,performanceWeek,performanceMonth,performanceYtd,performanceYear,performance3Year,technicalHour,technicalDay,technicalWeek,technicalMonth,avgVolume,fundamentalMarketCap,fundamentalRevenue,fundamentalRatio,fundamentalBeta,pairType',
                    'country-id' => '44',
                    'filter-domain' => '',
                    'page' => $page,
                    'page-size' => $stocks,
                    'limit' => '0',
                    'include-additional-indices' => 'false',
                    'include-major-indices' => 'false',
                    'include-other-indices' => 'false',
                    'include-primary-sectors' => 'false',
                    'include-market-overview' => 'false',
                ])->body();
                if (! $res) {
                    break;
                }
                if (str_contains($res , 'slice bounds out of range')) {
                    break;
                }
                $res = json_decode($res, true);
                foreach ($res['data'] as $data) {
                    $stock = Scrips::updateOrCreate(['symbol' => $data['Symbol']] , [
                        'name' => $data['Name'],
                        'fundamental_beta' => $data['FundamentalBeta'],
                        'fundamental_market_cap' => $data['FundamentalMarketCap'],
                        'fundamental_ratio' => $data['FundamentalRatio'],
                        'fundamental_revenue' => $data['FundamentalRevenue'],
                        'performance_3_year' => $data['Performance3Year'],
                        'performance_day' => $data['PerformanceDay'],
                        'performance_month' => $data['PerformanceMonth'],
                        'performance_week' => $data['PerformanceWeek'],
                        'performance_year' => $data['PerformanceYear'],
                        'performance_ytd' => $data['PerformanceYtd'],
                        'technical_day' => $data['TechnicalDay'],
                        'technical_hour' => $data['TechnicalHour'],
                        'technical_month' => $data['TechnicalMonth'],
                        'technical_week' => $data['TechnicalWeek'],
                    ]);
                    $dateTime =  Carbon::createFromTimestamp($data['Time']);
                    ScripData::updateOrCreate(['scrip_id' => $stock->id , 'scrip_date' => $dateTime->format('Y-m-d')] , [
                        'ldcp' => 0,
                        'open' => 0,
                        'high' => $data['High'],
                        'low' => $data['Low'],
                        'current' => $data['Last'],
                        'change' => $data['Chg'],
                        'volume' => $data['Volume'],
                        'change_per' => $data['ChgPct'],
                        'updated_at' => $dateTime->format('Y-m-d H:i:s'),
                    ]);
                }
                ++$page;
            }while(true);
        }catch (\Exception $exception) {
            app('log')->emergency('Exception in StockScrapping' , [
                'exception' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }
}
