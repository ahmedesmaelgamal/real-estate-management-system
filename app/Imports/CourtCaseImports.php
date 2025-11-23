<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\CourtCase;
use App\Models\CaseType;
use App\Models\JudiciatyType;
use App\Models\Association;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourtCaseImports implements ToModel, ToCollection, WithHeadingRow
{
    public Collection $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }

    public function model(array $row)
    {
        Log::info('Importing court case row', $row);

        // dd($row);
        // Fetch related models
        $caseType = CaseType::where('title->ar', $row['case_type_id'] ?? null)->orWhere('title->en', $row['case_type_id'] ?? null)->first();
        $judiciatyType = JudiciatyType::where('title->ar', $row['judiciaty_type_id'] ?? null)->orWhere('title->en', $row['judiciaty_type_id'] ?? null)->first();
        $association = Association::where('name->ar', $row['association_id'] ?? null)->orWhere('name->en', $row['association_id'] ?? null)->first();
        $owner = Association::where('name->ar', $row['owner_id'] ?? null)->orWhere('name->en', $row['owner_id'] ?? null)->first();
        $unit = Unit::where('unit_number', $row['unit_id'] ?? null)->first();

        // dd($unit , $row );
        // Create or update Court Case
        $courtCase = CourtCase::updateOrCreate(
            ['id' => $row['id'] ?? null],
            [
                'case_number'        => $row['case_number'] ?? null,
                'case_type_id'       => $caseType->id ?? null,
                'judiciaty_type_id'  => $judiciatyType->id ?? null,
                'association_id'     => $association->id ?? null,
                'owner_id'           => $owner->id ?? null,
                'unit_id'            => $unit->id ?? null,

                'case_date'          => $row['case_date'] ?? null,
                'case_price'         => $row['case_price'] ?? null,
                'judiciaty_date'     => $row['judiciaty_date'] ?? null,
                'topic'              => $row['topic'] ?? null,
                'description'        => $row['description'] ?? null,
            ]
        );

        return $courtCase;
    }
}
