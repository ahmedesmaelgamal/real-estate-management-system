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
                    <label for="description[ar]" class="form-control-label">{{ trns('description_ar') }}</label>
                    <textarea class="form-control" name="description[ar]" id="description_ar" rows="3"></textarea>
                </div>
            </div>
            <div class="col-12" id="interception_reason_container" >
                <div class="form-group">
                    <label for="description[en]" class="form-control-label">{{ trns('description_en') }}</label>
                    <textarea class="form-control" name="description[en]" id="description_en" rows="3"></textarea>
                </div>
            </div>
            <div>
                <h6 style="color:#00193a; font-weight: bold;">
                    {{ trns('status') }}<span class="text-danger">*</span>
                </h6>
                <div style="background-color: #E9E9E9; border-radius: 6px; padding: 10px; margin-bottom: 20px; display:flex;">
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <label class="form-check-label ms-2" for="statusToggle">{{trns('activate')}}</label>
                        <input class="form-check-input ms-0" type="checkbox" id="statusToggle" name="status" value="1" checked>
                    </div>
                    <label class="form-check-label me-3" for="statusToggle">{{trns('deactivate')}}</label>
                </div>
            </div>


        </div>

    </form>
</div>

