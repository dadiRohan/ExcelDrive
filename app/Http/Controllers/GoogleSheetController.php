<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleSheetController extends Controller
{
    public function syncAll(Request $request)
    {
        $rows = $request->input('rows');

        if (!$rows || !is_array($rows)) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        foreach ($rows as $row) {
            $empId = $row[0] ?? null;
            $name = $row[1] ?? null;
            $email = $row[2] ?? null;
            $phone = $row[3] ?? null;
            $status = $row[4] ?? null;

            if (!$empId) {
                continue; // skip empty rows
            }

            DB::table('contacts')->updateOrInsert(
                [
                    'emp_id' => $empId // unique key
                ], 
                [
                    'name'  => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'updated_at' => now()
                ]
            );
        }

        return response()->json([
            'message' => 'Sheet synced successfully',
            'rows_synced' => count($rows)
        ]);
    }
}
