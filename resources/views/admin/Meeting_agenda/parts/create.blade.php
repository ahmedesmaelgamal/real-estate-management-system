<div class="modal-body">
    <form id="addForm" class=" agendaAddForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf
        <div class="row">

            <input name="from_meet" type="hidden" value=1 />
            <!-- Arabic Name -->
            <div class="col-6">
                <div class="form-group">
                    <label for="name_ar" class="form-control-label">
                        {{ trns('name_ar') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="name[ar]" id="name_ar">
                </div>
            </div>

            <!-- English Name -->
            <div class="col-6">
                <div class="form-group">
                    <label for="name_en" class="form-control-label">
                        {{ trns('name_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" name="name[en]" id="name_en">
                </div>
            </div>

            <!-- Arabic Description -->
            <div class="col-6">
                <div class="form-group">
                    <label for="description_ar" class="form-control-label">
                        {{ trns('description_ar') }}
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" name="description[ar]" id="description_ar"></textarea>
                </div>
            </div>

            <!-- English Description -->
            <div class="col-6">
                <div class="form-group">
                    <label for="description_en" class="form-control-label">
                        {{ trns('description_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <textarea class="form-control" name="description[en]" id="description_en"></textarea>
                </div>
            </div>

            <!-- Date Field -->
            <div class="col-12">
                <div class="form-group">
                    <label for="date" class="form-control-label">
                        {{ trns('time') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input onclick="this.showPicker()" type="time" class="form-control" name="date"
                        id="date" required>

                </div>
            </div>
        </div>
    </form>
</div>

<!-- Dropify script -->
<script>
    $('.dropify').dropify();
</script>
