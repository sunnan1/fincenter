<?php

namespace App\Console\Commands;

use App\Models\Fund;
use App\Models\FundPerformance;
use Illuminate\Console\Command;
use PHPUnit\Exception;
use Spatie\Browsershot\Browsershot;

class ScrapFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-funds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Scraps the Funds Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $html = Browsershot::url('https://mufap.com.pk/Industry/IndustryStatDaily?tab=1')->bodyHtml();
            $dom = new \DOMDocument();
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_use_internal_errors($internalErrors);
            $xpath = new \DOMXPath($dom);
            $nodes = $xpath->query('//table[contains(@class, "table-bordered table-hover dataTable no-footer")]//tbody//tr');
            $type = '';
            foreach ($nodes as $node) {
                $cells = $node->getElementsByTagName('td');
                if ($cells->length == 1) {
                    if (str_contains($cells->item(0)->nodeValue, 'Annualized')) {
                        $type = 'ANNUALIZED';
                    }
                    if (str_contains($cells->item(0)->nodeValue, 'ABSOLUTE')) {
                        $type = 'ABSOLUTE';
                    }
                } else if ($cells->length > 1){
                    if (trim($cells->item(2)->nodeValue) == 'Fund Name') {
                        continue;
                    }
                    $fund = Fund::updateOrCreate(['name' => trim($cells->item(1)->nodeValue)] , [
                        'name'  => trim($cells->item(1)->nodeValue),
                        'return_type'  => $type,
                    ]);
                    FundPerformance::updateOrCreate(
                        [
                            'fund_id' => $fund->id,
                            'validity_date' => date('Y-m-d' , strtotime(trim($cells->item(4)->nodeValue))),
                        ],
                        [
                            'fund_id' => $fund->id,
                            'validity_date' => date('Y-m-d' , strtotime(trim($cells->item(4)->nodeValue))),
                            'nav' => floatval(trim($cells->item(5)->nodeValue)),
                            'ytd' => floatval(trim($cells->item(6)->nodeValue)),
                            'mtd' => floatval(trim($cells->item(7)->nodeValue)),
                            '1_day' => floatval(trim($cells->item(8)->nodeValue)),
                            '15_day' => floatval(trim($cells->item(9)->nodeValue)),
                            '30_day' => floatval(trim($cells->item(10)->nodeValue)),
                            '2_year' => floatval(trim($cells->item(15)->nodeValue)),
                            '3_year' => floatval(trim($cells->item(16)->nodeValue)),
                        ]
                    );
                }
            }
        }catch (Exception $exception) {
            app('log')->emergency('Exception in ScrapFunds' , [
                'exception' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }
}
