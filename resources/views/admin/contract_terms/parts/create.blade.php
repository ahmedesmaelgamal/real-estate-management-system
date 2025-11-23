
<div class="modal-body">
    <form id="addForm" class="addForm termFormCreate" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">{{ trns('title_ar') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title[ar]" id="title[ar]">
                </div>
            </div>
            <input type="hidden" value=1 name="from_contract" /> 
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">{{ trns('title_en') }}
                        {{-- <span
                            class="text-danger">*</span> --}}
                        </label>
                    <input type="text" class="form-control" name="title[en]" id="title[en]">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="description_ar" class="form-control-label">
                        {{ trns('description_ar') }} <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" name="description[ar]" id="description_ar" rows="4">{{ old('description.ar'?? '') }}</textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="description_en" class="form-control-label">
                        {{ trns('description_en') }}
                         {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <textarea class="form-control" name="description[en]" id="description_en" rows="4">{{ old('description.en'?? '') }}</textarea>
                </div>
            </div>

           
        </div>
    </form>
</div>
<!-- Dropify script -->
<script>
    $('.dropify').dropify();
</script>



<script>
    $('.dropify').dropify();
</script>
