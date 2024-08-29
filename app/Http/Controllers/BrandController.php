<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportBrandJob;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file');

        $filePath = $file->store('imports');

        ImportBrandJob::dispatch($filePath);

        return response()->json(['success' => 'The import process has started.'], 200);
    }
}
