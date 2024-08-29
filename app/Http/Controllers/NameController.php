<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportNameJob;
use Illuminate\Support\Facades\Storage;

class NameController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file');

        // Store the file temporarily
        $filePath = $file->store('imports');

        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Dispatch the job to process the import
        ImportNameJob::dispatch($filePath, $filename);

        return response()->json(['success' => 'The import process has started.'], 200);
    }
}
