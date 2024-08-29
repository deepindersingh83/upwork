<?php

namespace App\Imports;

use App\Models\Description;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DynamicDescImport implements ToCollection, WithHeadingRow, WithChunkReading
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

            // Extract SKU and description from the normalized row
            $sku = $normalizedRow['sku'] ?? $normalizedRow['primary_key'] ?? null;

            // Determine the correct description value and column
            $descriptionValue = $this->getDescriptionValue($normalizedRow);
            $descriptionColumn = $this->getDescriptionColumn($normalizedRow);

            if (!$sku || !$descriptionValue || !$descriptionColumn) {
                Log::warning("Skipping row due to missing SKU, Description Value, or Description Column. SKU: {$sku}, Description: {$descriptionValue}, Column: {$descriptionColumn}");
                continue;
            }

            // Find existing record by SKU
            $existingDesc = Description::where('sku', $sku)->first();
            
            if ($existingDesc) {
                // Log before updating
                Log::info("Found existing SKU: {$sku}, attempting to update {$descriptionColumn}.");

                // If SKU exists, update the corresponding description column
                $existingDesc->update([$descriptionColumn => $descriptionValue]);

                // Log after updating
                Log::info("Updated SKU: {$sku}, with {$descriptionColumn} => {$descriptionValue}");
            } else {
                // Log insertion
                Log::info("SKU not found, inserting new record for SKU: {$sku}");

                // If SKU doesn't exist, create a new record with the SKU and description
                Description::create([
                    'sku' => $sku,
                    $descriptionColumn => $descriptionValue,
                ]);

                Log::info("Inserted new SKU: {$sku}, with {$descriptionColumn} => {$descriptionValue}");
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;  // Process 1000 rows at a time
    }

    private function getDescriptionValue(array $normalizedRow): ?string
    {
        return $normalizedRow['description'] ?? $normalizedRow['short_description'] ?? null;
    }

    private function getDescriptionColumn(array $normalizedRow): ?string
    {
        if ($this->sheetName === 'alloy') {
            return isset($normalizedRow['short_description']) ? 'alloy_short_description' : 'alloy_description';
        }

        return match($this->sheetName) {
            'ls' => 'ls_description',
            'mmt' => 'mmt_description',
            'ds-standard-datafeed' => 'ds_description',
            'dd' => 'dd_description', // Assuming there's a column for dd_description if needed
            default => null
        };
    }
}
