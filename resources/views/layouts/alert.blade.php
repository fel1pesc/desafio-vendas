@if (session('validation'))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <span>{{ session('validation') }}</span>
            </div>
        </div>
    </div>
@endif
@if (session('status'))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <span>{{ session('status') }}</span>
            </div>
        </div>
    </div>
@endif