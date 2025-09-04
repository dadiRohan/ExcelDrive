<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleSheetService;
use App\Models\Contact;

class SyncGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:google-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Google Sheet with database';

    /**
     * Execute the console command.
     */
    public function handle(GoogleSheetService $sheetService)
    {
        /***
         * 
         * You Need to Set SpreadSheet Id 
         * eg. Google Excel URL :https://docs.google.com/spreadsheets/d/<YOUR-SPREADSHEET_ID>/edit?gid=0#gid=0
         * 
         * ***/
        $spreadsheetId = '1efhCwABHI5KKXisqFrdgFIWpeSotikgO7c3uWqlQTzo'; 
        $range = 'Sheet1!A2:E'; // Assuming headers in Row 1

        $rows = $sheetService->readSheet($spreadsheetId, $range);

        if (empty($rows)) {
            $this->error('No data found in the sheet.');
            return;
        }

        foreach ($rows as $row) {
            Contact::updateOrCreate(
                [
                    'emp_id' => $row[0] // unique column
                ], 
                [
                    'name'   => $row[1] ?? '',
                    'email'  => $row[2] ?? '',
                    'phone'  => $row[3] ?? '',
                    'status' => $row[4] ?? '',
                ]
            );
        }

        $this->info('Google Sheet synced successfully!');
    }
}
