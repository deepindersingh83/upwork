<?php

namespace App\Imports;

use App\Models\Name;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Description;
use App\Models\Ref;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AlloyImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $rowIndex = 0;

        foreach ($rows as $row) {
            $rowIndex++;

            // Skip the first row after the header
            if ($rowIndex == 1) {
                continue;
            }
            // Normalize the row keys to lowercase and trim all values
            $normalizedRow = array_change_key_case(array_map('trim', $row->toArray()), CASE_LOWER);

            $sku = $normalizedRow['sku'] ?? null;
            $alloyName = $normalizedRow['name'] ?? null;
            $brandName = $normalizedRow['brand'] ?? null;
            $categoryName1 = $normalizedRow['category_1'] ?? null;
            $categoryName2 = $normalizedRow['category_2'] ?? null;
            $categoryName3 = $normalizedRow['category_3'] ?? null;
            $costPrice =  $normalizedRow['cost_price'] ?? null;
            $rrp =  $normalizedRow['rrp'] ?? null;
            $short_alloy = $normalizedRow['short_description'] ?? null;
            $desc = $normalizedRow['description'] ?? null;
            $ean = $normalizedRow['ean'] ?? null;

            // Check if sku is present
            if (!$sku) {
                Log::warning("Skipping row due to missing sku.");
                continue;
            }

            // Process Name Table
            Name::updateOrCreate(
                ['sku' => $sku],
                ['alloy_name' => $alloyName]
            );

            // Process Brand Table
            Brand::updateOrCreate(
                ['brand_name' => $brandName]
            );

            // Process Category Table
            Category::updateOrCreate(
                ['sku' => $sku],
                [
                    'c1' => $categoryName1,
                    'c2' => $categoryName2,
                    'c3' => $categoryName3,
                ]
            );

            // Process Stock Table
            Stock::updateOrCreate(
                ['sku' => $sku],
                [
                    'alloy_cp' => $costPrice,
                    'rrp' => $rrp,
                ]
            );

            // Process Description Table
            Description::updateOrCreate(
                ['sku' => $sku],
                [
                    'alloy_short_description' => $short_alloy,
                    'alloy_description' => $desc,
                ]
            );

            // Process Ref Table
            Ref::updateOrCreate(
                ['sku' => $sku],
                ['ean' => $ean]
            );

            Log::info("Processed data for sku: {$sku}");
        }
    }

    public function chunkSize(): int
    {
        return 15;
    }
}
