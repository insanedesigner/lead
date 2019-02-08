@if(Session::has('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        {{Session::get('error')}}
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        {{Session::get('success')}}
    </div>
@endif

<?php
    Session::forget('error');
    Session::forget('success');
?>
