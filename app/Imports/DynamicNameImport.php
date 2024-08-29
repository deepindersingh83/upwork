<?php

namespace App\Imports;

use App\Models\Name;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DynamicNameImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct(protected string $sheetName)
    {
        //
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Log::info("Processing row:", $row->toArray());

            // Normalize the row keys to lowercase and trim all values
            $normalizedRow = array_change_key_case(array_map('trim', $row->toArray()), CASE_LOWER);

            // Extract SKU and name from the normalized row
            $sku = $normalizedRow['sku'] ?? $normalizedRow['primary_key'] ?? null;
            $nameValue = $normalizedRow['name'] ?? null;  // Ensure 'name' is correctly used as a string key

            if (!$sku || !$nameValue) {
                Log::warning("Skipping row due to missing SKU or Name Value. SKU: {$sku}, Name: {$nameValue}");
                continue;
            }

            // Determine the correct name column in the database based on the sheet name
            $nameColumn = $this->getNameColumn();
            if ($nameColumn === null) {
                Log::error("No matching column found in the database for sheet: {$this->sheetName}");
                continue;
            }

            // Find existing record by SKU and update or insert accordingly
            $existingName = Name::where('sku', $sku)->first();

            if ($existingName) {
                // If SKU exists, update the corresponding name column
                $existingName->update([$nameColumn => $nameValue]);
                Log::info("Updated SKU: {$sku}, with {$nameColumn} => {$nameValue}");
            } else {
                // If SKU doesn't exist, create a new record with the SKU and name
                Name::create([
                    'sku' => $sku,
                    $nameColumn => $nameValue,
                ]);
                Log::info("Inserted new SKU: {$sku}, with {$nameColumn} => {$nameValue}");
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;  // Process 1000 rows at a time
    }

    private function getNameColumn()
    {
        return match($this->sheetName) {
            'ls' => 'ls_name',
            'alloy' => 'alloy_name',
            'mmt'=> 'mmt_name',
            'ds-standard-datafeed' => 'ds_name',
            'dd' => 'dd_name',
            'Worksheet' => 'alloy_name',
            default => null
        };
    }
}
