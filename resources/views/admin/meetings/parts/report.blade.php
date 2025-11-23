@extends('admin.layouts.master')

@section('title')
    {{ trns('meeting_report') }}
@endsection

@section('page_name')
    {{ trns('meeting_report') }}
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
                            <h3 class="mt-3 fw-bold text-uppercase">{{ trns('meeting_report') }}</h3>
                            <p class="text-muted">
                                {{ trns('report_meeting_for_association') . ' : ' . ($meeting->association->getTranslation('name', app()->getLocale()) ?? '-') }}
                            </p>
                            <hr style="border-top: 2px solid #000; width: 60%; margin: 10px auto;">
                        </div>

                        {{-- Meeting Information --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('meeting_information') }}</h4>
                        <table class="table table-bordered table-sm mb-4">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">{{ trns('association') }}</th>
                                    <td>{{ $meeting->association->getTranslation('name', app()->getLocale()) ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('meeting_owner') }}</th>
                                    <td>{{ $meeting->owner->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('meeting_date') }}</th>
                                    <td>{{ $meeting->date ? \Carbon\Carbon::parse($meeting->date)->format('Y-m-d H:i') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trns('meeting_address') }}</th>
                                    <td>{{ $meeting->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trns('topics') }}</th>
                                    <td>
                                        @if ($meeting->topics->count())
                                            <ul class="mb-0">
                                                @foreach ($meeting->topics as $topic)
                                                    <li>{{ $topic->getTranslation('title', app()->getLocale()) }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ trns('no_topics_found') }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Attendees --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('meeting_attendees') }}</h4>
                        <table class="table table-bordered table-sm mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:5%;">#</th>
                                    <th>{{ trns('name') }}</th>
                                    <th>{{ trns('email') }}</th>
                                    <th>{{ trns('phone') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($meeting->users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name ?? '-' }}</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">{{ trns('no_attendees') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Agenda --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('meeting_agenda') }}</h4>
                        @if ($meeting->agendas)
                            <table class="table table-bordered table-sm mb-4">
                                @foreach ($meeting->agendas as $agenda)
                                    <tr>
                                        <th style="width:25%;">{{ trns('agenda_title') }}</th>
                                        <td>{{ $agenda->getTranslation('name', app()->getLocale()) ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p class="text-center text-muted">{{ trns('no_agenda_found') }}</p>
                        @endif

                        {{-- Summary --}}
                        <h4 class="fw-bold mb-3 text-decoration-underline">{{ trns('meeting_summary') }}</h4>
                        @if ($meeting->meetSummary && $meeting->meetSummary->count())
                            @foreach ($meeting->meetSummary as $summary)
                                <table class="table table-bordered table-sm mb-3">
                                    <tbody>
                                        <tr>
                                            <th style="width:25%;">{{ trns('summary_title') }}</th>
                                            <td>{{ $summary->getTranslation('title', app()->getLocale()) ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trns('summary_description') }}</th>
                                            <td>{{ $summary->getTranslation('description', app()->getLocale()) ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trns('summary_owner') }}</th>
                                            <td>{{ $summary->owner->name ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        @else
                            <p class="text-center text-muted">{{ trns('no_summary_found') }}</p>
                        @endif

                        {{-- Footer --}}
                        <div class="mt-5 text-center">
                            <hr style="border-top: 2px solid #000; width: 50%; margin: 20px auto;">
                            <p class="fw-bold mb-1">{{ trns('report_prepared_by') }}: {{ $meeting->owner->name ?? '-' }}
                            </p>

                            <p class="mb-4">{{ $setting->where('key', 'letterhead')->first()?->value ?? '' }}</p>

                            <p class="text-muted">{{ trns('signature_and_stamp') }}</p>
                            <div style="margin-top: 60px;">
                                <p>..................................................</p>
                            </div>
                        </div>
                    </div>

                    {{-- Print & Back --}}
                    <div class="d-print-none text-end mt-3 me-3">
                        <a style="color: white" onclick="printReport()" class="btn col-6 btn-one me-2">
                            <i class="fa fa-print"></i> {{ trns('print') }}
                        </a>
                        <a href="{{ route('meetings.index') }}" class="btn col-5 btn-two">{{ trns('back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('ajaxCalls')
<script>
    function printReport() {
        // Get the content to print
        const printContents = document.getElementById('cardPrint').innerHTML;

        // Save the original page content
        const originalContents = document.body.innerHTML;

        // Replace body with only the section you want to print
        document.body.innerHTML = `
            <html>
                <head>
                    <title>{{ trns('meeting_report') }}</title>
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

        // Print the content
        window.print();

        // Restore the original page content after printing
        document.body.innerHTML = originalContents;

        // Reload scripts/styles if needed
        window.location.reload();
    }
</script>
@endsection
