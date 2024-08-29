<?php

namespace App\Jobs;

use App\Imports\AlloyImport;
use App\Models\Name;
use App\Models\Brand;
use App\Models\Ref;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportAlloyDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            Excel::import(new AlloyImport, storage_path('app/' . $this->filePath));
        } catch (\Exception $e) {
            Log::error("Failed to import alloy data: {$e->getMessage()}");
        }
    }
}
