<?php

namespace App\Imports;

use App\Models\Dimensions;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class DimensionsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $normalizedRow = array_change_key_case(array_map('trim', $row->toArray()), CASE_LOWER);

            $sku = $normalizedRow['sku'] ?? null;
            $weight = $normalizedRow['weight'] ?? null;
            $length = $normalizedRow['length'] ?? null;
            $width = $normalizedRow['width'] ?? null;
            $height = $normalizedRow['height'] ?? null;

            if ($sku) {
                $existingDimensions = Dimensions::where('sku', $sku)->first();

                if ($existingDimensions) {
                    // Update the existing record
                    $existingDimensions->update([
                        'weight' => $weight,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                    ]);
                } else {
                    // Create a new record
                    Dimensions::create([
                        'sku' => $sku,
                        'weight' => $weight,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                    ]);
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }
}
