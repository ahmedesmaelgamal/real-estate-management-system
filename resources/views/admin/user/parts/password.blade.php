<div class="modal-body " style="text-align: right ; padding: 20px ;  text-align: center">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <br>
    <h4> {{ trns('generate_our_password_and_save_it_please') }}</h4>
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storePassRoute }}">
        @csrf
        @method("post")
        <input type="hidden" name="id" value="{{ $id }}" />

        <div class="row g-3">
            <div class="col-md-6">
                <label for="password" class="form-label">{{ trns('password') }}</label>
                <input type="password" class="form-control " name="password" id="password" autocomplete="new-password">
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">{{ trns('password_confirmation') }}</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn w-50 text-light" style="background-color: #00193A;" id="addButton">
                {{ trns('store') }}
            </button>
        </div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $('.dropify').dropify();

</script>
