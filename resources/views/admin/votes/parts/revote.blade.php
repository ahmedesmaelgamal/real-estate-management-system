<!-- <div class="modal-body"> -->
<form id="revote_form"  class="revote_form" method="POST" enctype="multipart/form-data" action="{{ $revoteRoute }}">
    @csrf
    @method('POST')
    <input type="hidden" value="{{ $obj->id }}" name="id">
    <div class="row">

        <!-- Association -->



        <div class="mb-5">
            <div class="alert alert-success mt-3" role="alert">
                <p id="cantDeleteMessage" class="fw-bold fs-7">{{ $obj->stage_number  == 1 ? trns("first_stage") : ($obj->stage_number == 2 ? trns("second_stage") : trns("third_stage")) }}</p>
            </div>
        </div>
        
        <div class="col-12"> 
            <label for="association_id" class="form-control-label">{{ trns('association') }}</label>
                <input class="form-control" name="association_id" value="{{$obj->association->localized_name}}" placeholder="{{$obj->association->getTranslation('name' , app()->getLocale())}}" disabled readonly />
           {{-- <select name="association_id" id="association_id" class="form-control">
               @foreach ($associations as $association)
                   <option value="{{ $association->id }}" {{ $association->id == $obj->association_id ? 'selected' : '' }}>
                       {{ $association->name }}
                   </option>
               @endforeach
           </select> --}}
        </div>

        <!-- Audience Number -->
        <div class="col-6">
            <label for="audience_number" class="form-control-label">{{ trns('audience_number') }}</label>
            <input type="number" value="{{ $owners_number }}"  readonly
                   class="form-control" name="audience_number" id="audience_number" required>
        </div>
        
        
        <!-- Unvoted Audience Number -->
        @if($currentDetail)
            <div class="col-6 mb-3">
                <label for="unvoted" class="form-control-label">{{ trns('unvoted_audience_number') }}</label>
                <input type="number"
                       class="form-control"
                       value="{{ $owners_number - ($currentDetail->yes_audience + $currentDetail->no_audience) }}"
                       readonly>
            </div>
        @endif

        <!-- Start Date -->
        <div class="col-4">
            <label for="start_date" class="form-control-label">{{ trns('vote_start_date') }}</label>
            <input type="date" onclick="this.showPicker()" class="form-control" name="start_date" id="start_date"
                   required>
        </div>

        <!-- End Date -->
        <div class="col-4">
            <label for="end_date" class="form-control-label">{{ trns('vote_end_date') }}</label>
            <input type="date" onclick="this.showPicker()" class="form-control" name="end_date" id="end_date"
                   required>
        </div>


        <!-- Vote Percentage -->
        <div class="col-4">
            <label for="vote_percentage" class="form-control-label">{{ trns('vote_percentage') }}</label>
            <input readonly type="number" step="0.01" class="form-control" name="vote_percentage"
                   value="{{ $obj->vote_percentage }}" id="vote_percentage" required>
        </div>
    </div>
</form>
<!-- </div> -->

<script>
    $('.dropify').dropify();



    initializeSelect2InModal('#association_id');
</script>
