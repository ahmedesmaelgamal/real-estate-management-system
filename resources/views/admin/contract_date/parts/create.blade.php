
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">{{ trns('title_ar') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title[ar]" id="title[ar]">
                </div>
            </div>
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
                    <label for="title_en" class="form-control-label">{{ trns('date') }}<span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date" id="date">
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Dropify script -->
<script>
    $('.dropify').dropify();
    initializeSelect2InModal('#contract_type_id');
</script>



<script>
    $('.dropify').dropify();
</script>
