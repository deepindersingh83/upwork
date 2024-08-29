<?php

namespace App\Imports;

use App\Models\Ref;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DynamicRefImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct(protected string $sheetName)
    {
        //
    }

    public function collection(Collection $rows)
    {
        $rowNumber = 0;

        foreach ($rows as $row) {
            $rowNumber++;
            Log::info("Processing row:", $row->toArray());

            // Normalize the row keys to lowercase and trim all values
            $normalizedRow = array_change_key_case(array_map('trim', $row->toArray()), CASE_LOWER);
              // Skip row number 2
              if ($rowNumber == 2) {
                Log::info("Skipping row number 2.");
                continue;
            }
            // Extract SKU and other fields from the normalized row
            $sku = $normalizedRow['sku'] ?? null;
            $upc = $normalizedRow['upc'] ?? null;
            $ean = $normalizedRow['ean'] ?? null;
            $barcode = $normalizedRow['barcode'] ?? null;
            $brandName = $normalizedRow['brand'] ?? null;  // Assuming the CSV has a 'brand' field

            if (!$sku) {
                Log::warning("Skipping row due to missing SKU. SKU: {$sku}");
                continue;
            }

            // Find brand_id based on brand name
            $brand = Brand::where('brand_name', $brandName)->first();
            $brandId = $brand ? $brand->id : null;

            if (!$brandId) {
                Log::warning("Skipping row due to missing or unmatched Brand ID for brand: {$brandName}");
                continue;
            }

            // Find existing record by SKU
            $existingRef = Ref::where('sku', $sku)->first();

            if ($existingRef) {
                // Log before updating
                Log::info("Found existing SKU: {$sku}, attempting to update.");

                // If SKU exists, update the corresponding fields
                $existingRef->update([
                    'upc' => $upc,
                    'ean' => $ean,
                    'barcode' => $barcode,
                    'brand_id' => $brandId,
                ]);

                // Log after updating
                Log::info("Updated SKU: {$sku} with UPC: {$upc}, EAN: {$ean}, Barcode: {$barcode}, Brand ID: {$brandId}");
            } else {
                // Log insertion
                Log::info("SKU not found, inserting new record for SKU: {$sku}");

                // If SKU doesn't exist, create a new record with the fields
                Ref::create([
                    'sku' => $sku,
                    'upc' => $upc,
                    'ean' => $ean,
                    'barcode' => $barcode,
                    'brand_id' => $brandId,
                ]);

                Log::info("Inserted new SKU: {$sku} with UPC: {$upc}, EAN: {$ean}, Barcode: {$barcode}, Brand ID: {$brandId}");
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;  // Process 1000 rows at a time
    }
}
