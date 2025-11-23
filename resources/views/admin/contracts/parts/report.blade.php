@extends('admin.layouts.master')

@section('title')
    {{ trns('contract_report') }}
@endsection

@section('page_name')
    {{ trns('contract_report') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body" id="cardPrint">

                        {{-- Header --}}
                        <div class="text-center mb-4">
                            <img src="{{ getFile($setting->where('key', 'logo')->first()->value) }}" class=" desktop-logo "
                                style="height:80px" alt="logo">
                            <h3 class="mt-3 fw-bold text-uppercase">{{ trns('contract_report') }}</h3>
                            <p class="text-muted">
                                {{ trns('report_contract_type') . ' : ' . ($contract->contractType->getTranslation('title', app()->getLocale()) ?? '-') }}
                            </p>
                            <hr style="border-top: 2px solid #000; width: 60%; margin: 10px auto;">
                        </div>

                        {{-- Contract Information --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('contract_information') }}</h4>
                        <table class="table table-bordered table-sm mb-4">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">{{ trns('contract_type') }}</th>
                                    <td>{{ $contract->contractType->title ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('contract_date') }}</th>
                                    <td>{{ $contract->date?->format('Y-m-d') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('contract_location') }}</th>
                                    <td>{{ $contract->contractLocation->title ?? $contract->contract_location }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('address') }}</th>
                                    <td>{{ $contract->contract_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('introduction') }}</th>
                                    <td>{{ $contract->introduction ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Contract Parties --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('contract_parties') }}</h4>
                        <table class="table table-bordered table-sm mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 25%;">{{ trns('party_type') }}</th>
                                    <th>{{ trns('name') }}</th>
                                    <th>{{ trns('address') }}</th>
                                    <th>{{ trns('phone') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ trns('first_party') }}</td>
                                    <td>{{ $contract->firstParties->first()->party_name ?? '-' }}</td>
                                    <td>{{ $contract->firstParties->first()->party_address ?? '-' }}</td>
                                    <td>{{ $contract->firstParties->first()->party_phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trns('second_party') }}</td>
                                    <td>{{ $contract->secondParties->first()->party_name ?? '-' }}</td>
                                    <td>{{ $contract->secondParties->first()->party_address ?? '-' }}</td>
                                    <td>{{ $contract->secondParties->first()->party_phone ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Contract Terms --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('contract_terms') }}</h4>
                        @if ($contract->contractTerms->count())
                            @foreach ($contract->contractTerms as $contractTerm)
                                <table class="table table-bordered table-sm mb-3">
                                    <tbody>
                                        <tr>
                                            <th style="width: 25%;">{{ trns('term_title') }}</th>
                                            <td>{{ $contractTerm->getTranslation('title', app()->getLocale()) }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trns('term_description') }}</th>
                                            <td>{{ $contractTerm->description ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        @else
                            <p class="text-center text-muted">{{ trns('no_terms_found') }}</p>
                        @endif

                        {{-- Footer --}}
                        <div class="mt-5 text-center">
                            <hr style="border-top: 2px solid #000; width: 50%; margin: 20px auto;">
                            <p class="fw-bold mb-1">{{ trns('report_prepared_by') }}:
                                {{ auth()->user()->name ?? '-' }}</p>


                            <p class="mb-4">{{ $setting->where('key', 'letterhead')->first()?->value ?? '' }}</p>



                            <p class="text-muted">{{ trns('signature_and_stamp') }}</p>
                            <div style="margin-top: 60px;">
                                <p>..................................................</p>
                            </div>
                        </div>
                    </div>

                    {{-- Print & Back --}}
                    <div class="d-print-none col-12 text-center  row">
                        <a style="color: white" onclick="printReport()" class="btn col-6 btn-one me-2">
                            <i class="fa fa-print"></i> {{ trns('print') }}
                        </a>
                        <a href="{{ route('contracts.index') }}" class="btn col-5 btn-two">{{ trns('back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ajaxCalls')
    <script>
        function printReport() {
            
            const printContents = document.getElementById('cardPrint').innerHTML;

            
            const originalContents = document.body.innerHTML;

            
            document.body.innerHTML = `
            <html>
                <head>
                    <title>{{ trns('contract_report') }}</title>
                    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
                    <style>
                        body {
                            padding: 40px;
                            font-family: "Times New Roman", serif;
                            color: #000;
                            font-size: 15px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 15px;
                        }
                        table th, table td {
                            border: 1px solid #444;
                            padding: 6px 10px;
                            vertical-align: top;
                        }
                        table th {
                            background-color: #f8f8f8;
                            font-weight: bold;
                        }
                        h4 {
                            margin-top: 25px;
                            font-size: 17px;
                        }
                        @media print {
                            .d-print-none { display: none !important; }
                        }
                    </style>
                </head>
                <body>
                    ${printContents}
                </body>
            </html>
        `;

            
            window.print();

            
            document.body.innerHTML = originalContents;

            
            window.location.reload();
        }
    </script>
@endsection
