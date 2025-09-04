<?php

namespace App\Services;

// use Google_Client;
// use Google_Service_Sheets;
use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected $service;

    public function __construct()
    {
        // $client = new Google_Client();
        // $client->setAuthConfig(storage_path('google\credentials.json'));
        // $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
        // $this->service = new Google_Service_Sheets($client);
        $client = new Client();
        $client->setApplicationName('Laravel Google Sheets');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig(storage_path('google\credentials.json'));
        $client->setAccessType('offline');

        $this->service = new Sheets($client);
    }

    public function readSheet($spreadsheetId, $range)
    {
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }
}
