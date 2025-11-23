<div class="modal-body">
    <form id="addForm" class="addForm termFormCreate" method="POST" enctype="multipart/form-data"
        action="{{ $storeRoute }}">
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
            <div class="col-6">
                <div class="form-group">
                    <label for="description_ar" class="form-control-label">{{ trns('description_ar') }}<span
                            class="text-danger">*</span></label>
                    <textarea rows="10" type="text" class="form-control" name="description[ar]" id="description[ar]"></textarea>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="description_en" class="form-control-label">{{ trns('description_en') }}
                        {{-- <span
                            class="text-danger">*</span> --}}
                    </label>
                    <textarea rows="10" type="text" class="form-control" name="description[en]" id="description[en]"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="owner_id" class="form-control-label">{{ trns('owner') }}<span
                            class="text-danger">*</span></label>
                    <select class="form-control" name="user_id" id="owner_id">
                        <option value="" selected disabled>{{ trns('select_owner') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="date" class="form-control-label">
                        {{ trns('date') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" class="form-control" name="date" id="date"
                       onclick="this.showPicker()"
                        required>


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
