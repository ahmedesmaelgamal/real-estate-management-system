<?php

namespace App\Exports;

use App\Models\RealState;
use App\Models\Association;
use App\Models\CourtCase;
use App\Models\Unit;
use App\Models\RealStateDetail;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;
use App\Models\Meeting;


class DynamicModelExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithColumnWidths,
    WithStyles
{
    protected $modelClass;
    protected $fileName;
    protected $withRelations = true;

    public function __construct($modelClass, $withRelations = true)
    {
        $this->modelClass = $modelClass;
        $this->withRelations = $withRelations;
        $modelName = Str::snake(class_basename($modelClass));
        $this->fileName = "{$modelName}_export_" . date('Y-m-d') . '.xlsx';
    }

    public function collection()
    {
        if ($this->modelClass === RealState::class && $this->withRelations) {
            return RealState::with('realStateDetails', 'association')->get();
        }

        if ($this->modelClass === Association::class && $this->withRelations) {
            return Association::with('AssociationManager')->get();
        }

        if ($this->modelClass === Unit::class && $this->withRelations) {
            return Unit::with('RealState')->get();
        }

        if ($this->modelClass === User::class && $this->withRelations) {
            return User::get();
        }

        if ($this->modelClass === \App\Models\Contract::class && $this->withRelations) {
            return \App\Models\Contract::with(
                'contractType',
                'contractName',
                'contractLocation',
                'contractTerms',
                'firstParty',
                'secondParty'
            )->get();
        }

        if ($this->modelClass === \App\Models\Vote::class && $this->withRelations) {
            return \App\Models\Vote::with([
                'association',
                'firstDetail',
                'secondDetail',
                'thirdDetail',
                'voteDetails',
            ])->get();
        }
        if ($this->modelClass === \App\Models\Meeting::class && $this->withRelations) {
            return \App\Models\Meeting::with([
                'association',
                'owner',
                'agenda',
                'topics'
            ])->get();
        }
        
        if ($this->modelClass === \App\Models\CourtCase::class && $this->withRelations) {
            return \App\Models\CourtCase::with([
                'caseType',
                'judiciatyType',
                'association',
                'owner',
                'caseUpdates',
                'unit'
            ])->get();
        }






        return $this->modelClass::all();
    }

    public function headings(): array
    {
        if ($this->modelClass === RealState::class) {
            return [
                // RealState fields (matches import structure)
                'name_ar',
                'name_en',
                'real_state_number',
                'association_id',
                'admin_id',
                'lat',
                'long',
                'stop_reason',
                'status',

                // RealStateDetails fields (matches import structure)
                'street',
                'space',
                'flat_space',
                'part_number',
                'bank_account_number',
                'mint_number',
                'mint_source',
                'floor_count',
                'elevator_count',
                'electric_account_number',
                'electric_meter_number',
                'electric_subscription_number',
                'water_account_number',
                'water_meter_number',
                'northern_border',
                'southern_border',
                'eastern_border',
                'western_border',
                'building_year',
                'building_type'
            ];
        }

        if ($this->modelClass === Association::class) {
            return [
                'name_ar',
                'name_en',
                'number',
                'unified_number',
                'establish_number',
                'establish_date',
                'due_date',
                'approval_date',
                'status',
                'interception_reason',
                'monthly_fees',
                'is_commission',
                'commission_name',
                'commission_type',
                'commission_percentage',
                'lat',
                'long',
                'logo',
                'association_manager_email',
                'association_model_id'
            ];
        }

        if ($this->modelClass === Unit::class) {
            return [
                'unit_number',
                'real_state_id',
                'bathrooms_count',
                'bedrooms_count',
                'floor_count',
                'unit_code',
                'unified_code',
                'space',
                'northern_border',
                'southern_border',
                'eastern_border',
                'western_border',
                'stop_reason',
                'description',
                'status'
            ];
        }
        if ($this->modelClass === User::class) {
            return [
                'name',
                'email',
                'national_id',
                'phone',
                'status'
            ];
        }

        if ($this->modelClass === \App\Models\Contract::class) {
            return [
                'id',
                'introduction',
                'date',
                'contract_type',
                'contract_name',
                'contract_location',
                'contract_address',
                "contract_first_party_title",
                'first_party_name',
                'first_party_nation_id',
                'first_party_phone',
                'first_party_email',
                'first_party_address',
                "contract_second_party_title",
                'second_party_name',
                'second_party_nation_id',
                'second_party_phone',
                'second_party_email',
                'second_party_address',
                'terms',
            ];
        }


        if ($this->modelClass === \App\Models\Vote::class) {
            return [
                // Vote main fields
                'id',
                'association_id',
                'status',
                'stage_number',
                'vote_percentage',

                // Stage 1 (firstDetail)
                'stage1_start_date',
                'stage1_end_date',
                'stage1_vote_percentage',
                'stage1_yes_audience',
                'stage1_no_audience',

                // Stage 2 (secondDetail)
                'stage2_start_date',
                'stage2_end_date',
                'stage2_vote_percentage',
                'stage2_yes_audience',
                'stage2_no_audience',

                // Stage 3 (thirdDetail)
                'stage3_start_date',
                'stage3_end_date',
                'stage3_vote_percentage',
                'stage3_yes_audience',
                'stage3_no_audience',
            ];
        }


        if ($this->modelClass === \App\Models\Meeting::class) {
            return [
                'id',
                'association',
                'owner',
                'agendas',
                'topics',
                'date',
                'address',
            ];
        }
        
        
        
        if ($this->modelClass === \App\Models\CourtCase::class) {
            return [
                'case_number',
                'case_type_id',
                'judiciaty_type_id',
                'association_id',
                'owner_id',
                'unit_id',
                'case_date',
                'case_price',
                'judiciaty_date',
                'topic',
                'description',
            ];
        }








        return [];
    }

    public function map($model): array
    {
        if ($this->modelClass === RealState::class) {
            return $this->mapRealState($model);
        }

        if ($this->modelClass === Association::class) {
            return $this->mapAssociation($model);
        }

        if ($this->modelClass === Unit::class) {
            return $this->mapUnit($model);
        }

        if ($this->modelClass === User::class) {
            return $this->mapUser($model);
        }
        if ($this->modelClass === \App\Models\Contract::class) {
            return $this->mapContract($model);
        }
        if ($this->modelClass === \App\Models\Vote::class) {
            return $this->mapVote($model);
        }

        if ($this->modelClass === Meeting::class) {
            return $this->mapMeeting($model);
        }
        
        if ($this->modelClass === CourtCase::class) {
            return $this->mapCourtCase($model);
        }




        return [];
    }

    protected function mapRealState($realState): array
    {
        return [
            // RealState fields
            $realState->getTranslation('name', 'ar') ?? '',
            $realState->getTranslation('name', 'en') ?? '',
            $realState->real_state_number,
            $realState->association_id,
            $realState->admin_id,
            $realState->lat,
            $realState->long,
            $realState->stop_reason,
            $realState->status ? 1 : 0,

            // RealStateDetails fields
            $realState->realStateDetails->street ?? '',
            $realState->realStateDetails->space ?? 0,
            $realState->realStateDetails->flat_space ?? 0,
            $realState->realStateDetails->part_number ?? '',
            $realState->realStateDetails->bank_account_number ?? '',
            $realState->realStateDetails->mint_number ?? 0,
            $realState->realStateDetails->mint_source ?? '',
            $realState->realStateDetails->floor_count ?? 0,
            $realState->realStateDetails->elevator_count ?? 0,
            $realState->realStateDetails->electric_account_number ?? '',
            $realState->realStateDetails->electric_meter_number ?? '',
            $realState->realStateDetails->electric_subscription_number ?? '',
            $realState->realStateDetails->water_account_number ?? '',
            $realState->realStateDetails->water_meter_number ?? '',
            $realState->realStateDetails->northern_border ?? '',
            $realState->realStateDetails->southern_border ?? '',
            $realState->realStateDetails->eastern_border ?? '',
            $realState->realStateDetails->western_border ?? '',
            $realState->realStateDetails->building_year ?? '',
            $realState->realStateDetails->building_type ?? '',
        ];
    }

    protected function mapAssociation($association): array
    {
        return [
            $association->getTranslation('name', 'ar') ?? '',
            $association->getTranslation('name', 'en') ?? '',
            $association->number,
            $association->unified_number,
            $association->establish_number,
            $association->establish_date,
            $association->due_date,
            $association->approval_date,
            $association->status ? 1 : 0, // Matches import's boolean format
            $association->interception_reason,
            $association->monthly_fees,
            $association->is_commission ? 1 : 0,
            $association->commission_name,
            $association->commission_type ? 1 : 0,
            $association->commission_percentage,
            $association->lat,
            $association->long,
            $association->logo,
            $association->AssociationManager->email ?? '',
            $association->AssociationModel->title ?? '',
            $association->appointment_start_date,
            $association->appointment_end_date

        ];
    }

    protected function mapUnit($unit): array
    {
        return [
            $unit->unit_number,
            $unit->real_state_id,
            $unit->bathrooms_count,
            $unit->bedrooms_count,
            $unit->floor_count,
            $unit->unit_code,
            $unit->unified_code,
            $unit->space,
            $unit->northern_border,
            $unit->southern_border,
            $unit->eastern_border,
            $unit->western_border,
            $unit->stop_reason,
            $unit->description,
            $unit->status ? 1 : 0 // Matches import's boolean format
        ];
    }

    protected function mapUser($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->national_id,
            $user->phone,
            $user->status ? 1 : 0
        ];
    }

    protected function mapContract($contract): array
    {
        $data = [
            $contract->id,
            $contract->introduction,
            optional($contract->date)->format('Y-m-d'),

            // relations
            $contract->contractType?->getTranslation('title', app()->getLocale()) ?? '',
            $contract->contractName?->getTranslation('name', app()->getLocale()) ?? '',
            $contract->contractLocation?->getTranslation('title', app()->getLocale()) ?? '',
            $contract->contract_address ?? '',

            // first party
            \App\Models\ContractParty::find($contract->contract_first_party_id)?->getTranslation('title', app()->getLocale()) ?? '',
            $contract->firstParty?->party_name ?? '',
            $contract->firstParty?->party_nation_id ?? '',
            $contract->firstParty?->party_phone ?? '',
            $contract->firstParty?->party_email ?? '',
            $contract->firstParty?->party_address ?? '',

            // second party
            \App\Models\ContractParty::find($contract->contract_second_party_id)?->getTranslation('title', app()->getLocale()) ?? '',
            $contract->secondParty?->party_name ?? '',
            $contract->secondParty?->party_nation_id ?? '',
            $contract->secondParty?->party_phone ?? '',
            $contract->secondParty?->party_email ?? '',
            $contract->secondParty?->party_address ?? '',
        ];

        // Add each term in a separate column
        $contract->contractTerms?->each(function ($term, $index) use (&$data) {
            $title = $term->getTranslation('title', app()->getLocale()) ?? '-';
            $description = $term->description;
            $data[] = $title . " : " . $description;
        });

        return $data;
    }


    protected function mapVote($vote): array
    {
        return [
            // Vote main fields
            $vote->id,
            $vote->association->getTranslation('name', app()->getLocale()) ?? '',
            $vote->status ? 1 : 0,
            $vote->stage_number,
            $vote->vote_percentage,

            // Stage 1 (firstDetail)
            optional($vote->firstDetail)->start_date ?? '',
            optional($vote->firstDetail)->end_date ?? '',
            optional($vote->firstDetail)->vote_percentage ?? '',
            optional($vote->firstDetail)->yes_audience ?? 0,
            optional($vote->firstDetail)->no_audience ?? 0,

            // Stage 2 (secondDetail)
            optional($vote->secondDetail)->start_date ?? '',
            optional($vote->secondDetail)->end_date ?? '',
            optional($vote->secondDetail)->vote_percentage ?? '',
            optional($vote->secondDetail)->yes_audience ?? 0,
            optional($vote->secondDetail)->no_audience ?? 0,

            // Stage 3 (thirdDetail)
            optional($vote->thirdDetail)->start_date ?? '',
            optional($vote->thirdDetail)->end_date ?? '',
            optional($vote->thirdDetail)->vote_percentage ?? '',
            optional($vote->thirdDetail)->yes_audience ?? 0,
            optional($vote->thirdDetail)->no_audience ?? 0,
        ];
    }


    protected function mapMeeting($meeting): array
    {
        $data = [
            $meeting->id,
            $meeting->association?->getTranslation('name', app()->getLocale()) ?? '-',
            $meeting->owner?->name ?? '-',
            // كل الأجندة في مصفوفة واحدة
            $meeting->agendas->isNotEmpty()
                ? $meeting->agendas
                ->map(fn($agenda) => $agenda->getTranslation('name', app()->getLocale()))
                ->toArray()
                : [],
            // المواضيع
            $meeting->topics->isNotEmpty()
                ? $meeting->topics
                ->map(fn($t) => $t->getTranslation('title', app()->getLocale()))
                ->implode(', ')
                : trns('no_topics_found'),
            // التاريخ
            $meeting->date ? \Carbon\Carbon::parse($meeting->date)->format('Y-m-d H:i:s') : '-',
            // العنوان
            $meeting->address ?? '-',
        ];

        return $data;
    }
    
    
    protected function mapCourtCase($courtCase): array
    {
        $data = [
            $courtCase->case_number,
            $courtCase->caseType?->getTranslation('title', app()->getLocale()) ?? '-',
            $courtCase->judiciatyType?->getTranslation('title', app()->getLocale()) ?? '-',
            $courtCase->association?->getTranslation('name', app()->getLocale()) ?? '-',
            $courtCase->owner?->name ?? '-',
            $courtCase->unit?->unit_number ?? '-',
            $courtCase->case_date ?? '-',
            $courtCase->case_price ?? '-',
            $courtCase->judiciaty_date ?? '-',
            $courtCase->topic ?? '-',
            $courtCase->description ?? '-',
        ];

        return $data;
    }







    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 15,
            'E' => 15,
            'F' => 30,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 15,
            'L' => 15,
            'M' => 20,
            'N' => 15,
            'O' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ],

            'A:Z' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],

            'A1:Z' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
