<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class BrandImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $normalizedRow = array_change_key_case(array_map('trim', $row->toArray()), CASE_LOWER);

            $brandName = $normalizedRow['brand'] ?? null;

            if ($brandName) {
                $existingBrand = Brand::where('brand_name', $brandName)->first();

                if (!$existingBrand) {
                    Brand::create([
                        'brand_name' => $brandName,
                    ]);
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
