# <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="100" alt="Laravel Logo">Excel Drive Access</a> </p> 

## For Generated Excel Sheet Data add/update to Mysql Databse

### Steps for Process (You Should run Via CRON or Via API)

### [A] Via CRON
1. First Clone this project
2. make migration
3. In Google Cloud Console Steps :
4. Enable Google Sheets API
5. Create a Service Account (IAM & Admin → Service Accounts → Create → Key → JSON)
6. Download JSON (it will contain "type": "service_account")    
7. Save that JSON in storage/google/credentials.json
8. Create New SpreadSheet and add data for example : https://docs.google.com/spreadsheets/d/1efhCwABHI5KKXisqFrdgFIWpeSotikgO7c3uWqlQTzo/edit?gid=0#gid=0
9. get that SpreadsheetId and Save into File : SyncGoogleSheet.php    
10. If you want to Run via Schedular then Set in Console/Kernel.php

### [B] Via API
1. Above 8 Steps are common
2. Now in SpreadSheet go to Extensions -> App Script 

```
function syncEntireSheet() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var data = sheet.getDataRange().getValues(); // all rows including header

  // Optionally remove header row
  data.shift();

  var payload = {
    rows: data
  };

  var options = {
    method: "post",
    contentType: "application/json",
    payload: JSON.stringify(payload)
  };

  var response = UrlFetchApp.fetch("<SITE_URL>/api/google-sheet-sync-all?sheet_id=<SHEET_ID>", options);
  Logger.log(response.getContentText());
}
```
3. Now deploy that script in App Script and Set Schedular -> Add Trigger -> Save
4. So when user make changes it will directly reflect into database without laravel queue.

