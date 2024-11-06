<?php

namespace App\Console\Commands;

use App\Models\ScripData;
use App\Models\Scrips;
use App\Models\Sectors;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\Browsershot\Browsershot;

class ScrapSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scraps The PSX Summary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            if (Carbon::today()->isSaturday() || Carbon::today()->isSunday()) {
                return;
            }
            $html = Browsershot::url('https://www.psx.com.pk/market-summary/')->bodyHtml();
            $dom = new \DOMDocument();
            $internalErrors = libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_use_internal_errors($internalErrors);
            $xpath = new \DOMXPath($dom);
            $nodes = $xpath->query('//div[contains(@class, "tab-pane inner-content-table automobile-div")]//div[contains(@class, "table-responsive")]/table');
            foreach ($nodes as $table) {
                $sectorNode = $xpath->query('.//thead/tr/th/h4', $table)->item(0);
                $sectorName = $sectorNode ? trim($sectorNode->nodeValue) : 'Unknown Sector';
                $sector = Sectors::updateOrCreate(['name' => $sectorName] , ['name' => $sectorName]);
                $rows = $xpath->query('.//tbody', $table)->item(0);
                $rows = $rows->getElementsByTagName('tr');
                foreach ($rows as $index => $row) {
                    if ($index == 0) continue;
                    $cells = $row->getElementsByTagName('td');
                    if ($cells->length >= 8) { // Ensure we have all necessary columns
                        $stock = Scrips::updateOrCreate(['name' => trim($cells->item(0)->nodeValue)] , ['name' => trim($cells->item(0)->nodeValue) , 'sector_id' => $sector->id]);
                        $stockData = [
                            'ldcp' => floatval(str_replace(',','',trim($cells->item(1)->nodeValue))),
                            'open' => floatval(str_replace(',','',trim($cells->item(2)->nodeValue))),
                            'high' => floatval(str_replace(',','',trim($cells->item(3)->nodeValue))),
                            'scrip_id' => $stock->id,
                            'scrip_date' => date('Y-m-d'),
                            'low' => floatval(str_replace(',','',trim($cells->item(4)->nodeValue))),
                            'current' => floatval(str_replace(',','',trim($cells->item(5)->nodeValue))),
                            'change' => floatval(str_replace(',','',trim($cells->item(6)->nodeValue))),
                            'volume' => floatval(str_replace(',','',trim($cells->item(7)->nodeValue))),
                        ];
                        ScripData::updateOrCreate(['scrip_id' => $stock->id , 'scrip_date' => date('Y-m-d')] , $stockData);
                    }
                }
            }
        }catch (\Exception $exception) {
            app('log')->emergency('Exception in ScrapSummary' , [
                'exception' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }
}
