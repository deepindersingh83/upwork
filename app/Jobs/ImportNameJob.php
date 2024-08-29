<?php

namespace App\Jobs;

use App\Imports\DynamicNameImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportNameJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(protected $filePath, protected $filename)
    {
        //
    }

    public function handle()
    {
        try {
            $spreadsheet = IOFactory::load(storage_path('app/' . $this->filePath));
            $sheetNames = $spreadsheet->getSheetNames();

            if (count($sheetNames) > 0) {
                $sheetName = $sheetNames[0]; // Assuming you are uploading one sheet per file
                Excel::import(new DynamicNameImport($this->filename), $this->filePath);
            } else {
                Log::error("No sheets found in the uploaded file.");
            }
        } catch (\Exception $e) {
            Log::error("Failed to import the file: {$e->getMessage()}");
        }
    }
}
