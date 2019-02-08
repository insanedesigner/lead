<script type="text/javascript" src="{!! asset('public/assets/plugins/jquery/jquery.min.js') !!}"></script>


<!-- Bootstrap tether Core JavaScript -->
<script type="text/javascript" src="{!! asset('public/assets/plugins/bootstrap/js/popper.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('public/assets/plugins/bootstrap/js/bootstrap.min.js') !!}"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script type="text/javascript" src="{!! asset('public/assets/js/jquery.slimscroll.js') !!}"></script>

<!--Wave Effects -->
<script type="text/javascript" src="{!! asset('public/assets/js/waves.js') !!}"></script>

<!--Menu sidebar -->
<script type="text/javascript" src="{!! asset('public/assets/js/sidebarmenu.js') !!}"></script>

<!--stickey kit -->
<script type="text/javascript" src="{!! asset('public/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') !!}"></script>

<!--Custom JavaScript -->
<script type="text/javascript" src="{!! asset('public/assets/js/custom.min.js') !!}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!--sparkline JavaScript -->
<script type="text/javascript" src="{!! asset('public/assets/plugins/sparkline/jquery.sparkline.min.js') !!}"></script>


<!--morris JavaScript -->
<script type="text/javascript" src="{!! asset('public/assets/plugins/raphael/raphael-min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('public/assets/plugins/morrisjs/morris.min.js') !!}"></script>

<!-- Chart JS -->
<script type="text/javascript" src="{!! asset('public/assets/js/dashboard1.js') !!}"></script>

<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script type="text/javascript" src="{!! asset('public/assets/plugins/styleswitcher/jQuery.style.switcher.js') !!}"></script>


<script>
    setInterval(function()
    {
       $('.alert').remove();
    }, 3000);

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });


</script>


@yield('scripts')
