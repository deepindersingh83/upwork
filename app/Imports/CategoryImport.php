<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class CategoryImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $normalizedRow = array_change_key_case(array_map('trim', $row->toArray()), CASE_LOWER);

            $sku = $normalizedRow['sku'] ?? null;
            $c1 = $normalizedRow['category 1'] ?? null;
            $c2 = $normalizedRow['category 2'] ?? null;
            $c3 = $normalizedRow['category 3'] ?? null;
            $c4 = $normalizedRow['category 4'] ?? null;

            if ($sku) {
                $existingCategory = Category::where('sku', $sku)->first();

                if (!$existingCategory) {
                    Category::create([
                        'sku' => $sku,
                        'c1' => $c1,
                        'c2' => $c2,
                        'c3' => $c3,
                        'c4' => $c4,
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
