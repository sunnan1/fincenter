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
                    if (str_contains($cells->item(0)->nodeValue, 'Absolute')) {
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
                            'nav' => $this->formatValue($cells->item(5)->nodeValue),
                            'ytd' => $this->formatValue(trim($cells->item(6)->nodeValue)),
                            'mtd' => $this->formatValue(trim($cells->item(7)->nodeValue)),
                            'day_1' => $this->formatValue(trim($cells->item(8)->nodeValue)),
                            'day_15' => $this->formatValue(trim($cells->item(9)->nodeValue)),
                            'day_30' => $this->formatValue(trim($cells->item(10)->nodeValue)),
                            'year_2' => $this->formatValue(trim($cells->item(15)->nodeValue)),
                            'year_3' => $this->formatValue(trim($cells->item(16)->nodeValue)),
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

    public function formatValue($value) {
        if (str_contains($value, '(')) {
            $value = str_replace("(" , "" , $value);
            $value = str_replace(")" , "" , $value);
            return -1*floatval(trim($value));
        }
        return floatval(trim($value));
    }
}
