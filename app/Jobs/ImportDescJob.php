<?php

namespace App\Jobs;

use App\Imports\DynamicDescImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportDescJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $sheetName;

    public function __construct($filePath, $sheetName)
    {
        $this->filePath = $filePath;
        $this->sheetName = $sheetName; // This is actually the filename
    }

    public function handle()
    {
        try {
            Excel::import(new DynamicDescImport($this->sheetName), $this->filePath);
        } catch (\Exception $e) {
            Log::error("Failed to import the file: {$e->getMessage()}");
        }
    }
}
