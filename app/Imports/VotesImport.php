<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\ContractName;
use App\Models\ContractLocation;
use App\Models\ContractTerm;
use App\Models\ContractPartyDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VotesImport implements ToModel, ToCollection, WithHeadingRow
{
    public Collection $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }

    public function model(array $row)
    {
        Log::info('Importing contract row', $row);

        // Fetch related models
        $contractType = ContractType::where('title->ar', $row['contract_type_ar'])->first();
        $contractName = ContractName::where('name->ar', $row['contract_name_ar'])->first();
        $contractLocation = ContractLocation::where('title->ar', $row['contract_location_ar'])->first();

        // Create or update main contract
        $contract = Contract::updateOrCreate(
            ['id' => $row['id'] ?? null],
            [
                'contract_type_id' => $contractType->id ?? null,
                'contract_name_id' => $contractName->id ?? null,
                'date' => $row['date'] ?? now(),
                'contract_location_id' => $contractLocation->id ?? null,
                'introduction' => $row['introduction'] ?? null,
                'contract_address' => $row['contract_address'] ?? null,
                'admin_id' => Auth::guard('admin')->id(),
            ]
        );

        // Handle Contract Terms (many-to-many)
        if (!empty($row['contract_terms_ids'])) {
            $termIds = explode(',', $row['contract_terms_ids']); // CSV of term IDs
            $contract->contractTerms()->sync($termIds);
        }

        // Handle first party
        if (!empty($row['first_party_name'])) {
            ContractPartyDetail::updateOrCreate(
                ['contract_id' => $contract->id, 'party_type' => 'first'],
                [
                    'party_name' => $row['first_party_name'] ?? null,
                    'party_nation_id' => $row['first_party_nation_id'] ?? null,
                    'party_phone' => $row['first_party_phone'] ?? null,
                    'party_email' => $row['first_party_email'] ?? null,
                    'party_address' => $row['first_party_address'] ?? null,
                ]
            );
        }

        // Handle second party
        if (!empty($row['second_party_name'])) {
            ContractPartyDetail::updateOrCreate(
                ['contract_id' => $contract->id, 'party_type' => 'second'],
                [
                    'party_name' => $row['second_party_name'] ?? null,
                    'party_nation_id' => $row['second_party_nation_id'] ?? null,
                    'party_phone' => $row['second_party_phone'] ?? null,
                    'party_email' => $row['second_party_email'] ?? null,
                    'party_address' => $row['second_party_address'] ?? null,
                ]
            );
        }

        return $contract;
    }
}
