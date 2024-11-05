<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $request = Http::get('https://www.psx.com.pk/market-summary/');
        $dom = new \DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($request->body());
        libxml_use_internal_errors($internalErrors);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//div[contains(@class, "tab-content")]//div[contains(@class, "table-responsive")]');

        foreach ($nodes as $node) {
            $table = $xpath->query('.//table', $node)->item(0);
            if ($table) {
                $th_h4 = $xpath->query('.//thead/tr/th/h4', $table)->item(0);
                if ($th_h4) {
                    $sector = trim($th_h4->nodeValue);
                }
            }

            $rows = $xpath->query('.//tbody/tr', $table);
            foreach ($rows as $row) {
                $rowData = [];
                // Loop through each cell in the row
                $cells = $xpath->query('.//td', $row);
                foreach ($cells as $cell) {
                    $rowData[] = trim($cell->nodeValue); // Collect cell data
                }
                // Print or process the row data
                echo "Row Data: " . implode(", ", $rowData) . "\n";
            }

        }

    }
}
