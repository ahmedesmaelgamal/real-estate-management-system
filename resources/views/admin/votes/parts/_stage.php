<div class="show-content mt-3"
     style="border-radius: 6px; background-color: #fbf9f9; border: 1px solid #ddd; padding: 15px;">
    <h4 style="font-weight: bold; color: #00193a;">
        {{ trns('basic_information_of_votes') }}
    </h4>
    <hr style="background-color: black;">
    <div class="row m-4">
        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('association_name') }}</h6>
            <p class="fw-bold">
                {{ $obj->association?->getTranslation('name', app()->getLocale()) ?? trns('no data') }}
            </p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('created_at') }}</h6>
            <p class="fw-bold">
                {{ $obj->created_at?->format('Y-m-d') ?? trns('N/A') }}
            </p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('vote_start_date') }}</h6>
            <p class="fw-bold">
                {{ $detail?->start_date?->format('Y-m-d') ?? trns('N/A') }}
            </p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('vote_end_date') }}</h6>
            <p class="fw-bold">
                {{ $detail?->end_date?->format('Y-m-d') ?? trns('N/A') }}
            </p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('stop_percentage') }}</h6>
            <p class="fw-bold">
                {{ $obj->vote_percentage ?? trns('N/A') }}
            </p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('status') }}</h6>
            <p>
                @if ($obj->status == 1)
                <span class="badge px-3 py-2" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">
                        {{ trns('active') }}
                    </span>
                @else
                <span class="badge px-3 py-2" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">
                        {{ trns('inactive') }}
                    </span>
                @endif
            </p>
        </div>
    </div>
</div>

{{-- Votes Management --}}
<div class="col-12 mt-4"
     style="border-radius: 6px; background-color: #fbf9f9; border: 1px solid #ddd; padding: 15px;">
    <h4 style="font-weight: bold; color: #00193a;">{{ trns('votes_management') }}</h4>
    <hr style="background-color: black;">
    <div class="row m-4">
        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('owners_number') }}</h6>
            <p class="fw-bold">{{ $owners_count ?? trns('no data') }}</p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('voters_percentage') }}</h6>
            <p class="fw-bold">
                @php
                $audience = $detail ? ($detail->yes_audience + $detail->no_audience) : 0;
                $percentage = $owners_count > 0 ? ($audience / $owners_count) * 100 : null;
                @endphp
                {{ $percentage !== null ? number_format($percentage, 2) . '%' : trns('N/A') }}
            </p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('yes_voters') }}</h6>
            <p class="fw-bold">{{ $detail?->yes_audience ?? trns('N/A') }}</p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('no_voters') }}</h6>
            <p class="fw-bold">{{ $detail?->no_audience ?? trns('N/A') }}</p>
        </div>

        <div class="col-2">
            <h6 class="text-uppercase text-muted">{{ trns('unVoters') }}</h6>
            <p class="fw-bold">
                {{ $owners_count - ($detail?->yes_audience + $detail?->no_audience) }}
            </p>
        </div>
    </div>
</div>
