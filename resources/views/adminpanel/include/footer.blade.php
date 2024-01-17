</div>
</div>
{{--Footer Start--}}

<script src="{{asset('assets/bootstrap-polaris.js')}}"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>

<script src="{{ asset('polished_asset/select2/js/select2.full.js') }}"></script>
<script src="{{asset('admin_custom.js')}}?{{now()}}"></script>

<script>
    $(document).ready(function() {
        $('.custom-select2').select2();
    });

    $('body').find('.ckeditors').each(function() {
        CKEDITOR.replace($(this).attr('id'));
    });
    $('.custom-ckeditor').find('.ckeditors').each(function() {
        CKEDITOR.replace($(this).attr('id'));
    });



</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{{--    daterange picker--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.2.1/trianglify.min.js"></script>
<script type="text/javascript" src="{{asset('daterangepicker-master/daterangepicker.js')}}"></script>

<script>
    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}") ;
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}") ;
    @endif

</script>

@yield('script')

</body>
</html>
{{--Footer End--}}
