
<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">{{ trns('title_ar') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name[ar]" id="title[ar]"
                           value="{{ $obj->getTranslation('name', 'ar') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">{{ trns('title_en') }}
                        {{-- <span
                            class="text-danger">*</span> --}}
                        </label>
                    <input type="text" class="form-control" name="name[en]" id="title[en]"
                           value="{{ $obj->getTranslation('name', 'en') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">{{ trns('types_settings') }}<span
                            class="text-danger">*</span></label>
                    <select name="contract_type_id" id="contract_type_id">
                        @foreach($contractTypes as $contractType)
                            <option {{$obj->contract_type_id == $contractType->id ? "selected" : "-"}} value="{{$contractType->id}}">{{$contractType->getTranslation('title', app()->getLocale())}}</option>
                        @endforeach

                    </select>
                </div>
            </div>


        </div>
    </form>
</div>

<script>
    $('#select_all').click(function() {
        var checked = this.checked;
        $('.permission-checkbox').each(function() {
            this.checked = checked;
        });
    });
</script>

<!-- Dropify script -->
<script>
    $('.dropify').dropify();
    initializeSelect2InModal('#contract_type_id');
</script>

