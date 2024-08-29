<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportDimensionsJob;
use Illuminate\Support\Facades\Storage;

class DimensionsController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file');

        // Store the file temporarily
        $filePath = $file->store('imports');

        // Dispatch the job to process the import
        ImportDimensionsJob::dispatch($filePath);

        return response()->json(['success' => 'The import process has started.'], 200);
    }
}
