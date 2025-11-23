    <form id="updateForm" class="updateForm caseUpdateModel" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">

        <div class="row">
            {{-- Arabic Title --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">
                        {{ trns('title_ar') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="title[ar]" id="title[ar]"
                           value="{{ $obj->getTranslation('title', 'ar') }}">
                </div>
            </div>

            {{-- English Title --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">
                        {{ trns('title_en') }}
                    </label>
                    <input type="text" class="form-control" name="title[en]" id="title[en]"
                           value="{{ $obj->getTranslation('title', 'en') }}">
                </div>
            </div>


        </div>
    </form>

<!-- Dropify script -->
<script>
    $('.dropify').dropify();
</script>
