<?php

namespace App\Jobs;

use App\Imports\DynamicRefImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportRefJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $filename;

    public function __construct($filePath, $filename)
    {
        $this->filePath = $filePath;
        $this->filename = $filename;
    }

    public function handle()
    {
        try {
            Excel::import(new DynamicRefImport($this->filename), $this->filePath);
        } catch (\Exception $e) {
            Log::error("Failed to import the file: {$e->getMessage()}");
        }
    }
}
