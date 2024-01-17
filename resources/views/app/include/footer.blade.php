</div>
</div>
{{--Footer Start--}}
<script src="{{asset('assets/bootstrap-polaris.js')}}"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>

<script src="{{ asset('polished_asset/select2/js/select2.full.js') }}"></script>
<script src="{{asset('app_custom.js')}}?{{now()}}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

@yield('script')
<script>
    $(document).ready(function() {
        $(document).on('click','.close-loader',function (){
            $(this).parent('.loading').css("display","none")
        });
        $('.custom-select2').select2();
    });

    // $('body').find('.ckeditors').each(function() {
    //     CKEDITOR.replace($(this).attr('id'));
    // });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}") ;
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}") ;
    @endif

</script>

{{--@if(\Osiset\ShopifyApp\Util::getShopifyConfig('appbridge_enabled'))--}}
{{--    <script src="https://unpkg.com/@shopify/app-bridge{{ \Osiset\ShopifyApp\Util::getShopifyConfig('appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>--}}
{{--    <script src="https://unpkg.com/@shopify/app-bridge-utils{{ \Osiset\ShopifyApp\Util::getShopifyConfig('appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>--}}
{{--    <script--}}
{{--        @if(\Osiset\ShopifyApp\Util::getShopifyConfig('turbo_enabled'))--}}
{{--        data-turbolinks-eval="false"--}}
{{--        @endif--}}
{{--    >--}}
{{--        var AppBridge = window['app-bridge'];--}}
{{--        var actions = AppBridge.actions;--}}
{{--        var utils = window['app-bridge-utils'];--}}
{{--        var createApp = AppBridge.default;--}}
{{--        var app = createApp({--}}
{{--            apiKey: "{{ \Osiset\ShopifyApp\Util::getShopifyConfig('api_key', $shopDomain ?? Auth::user()->name ) }}",--}}
{{--            shopOrigin: "{{ $shopDomain ?? Auth::user()->name }}",--}}
{{--            host: "{{ \Request::get('host') }}",--}}
{{--            forceRedirect: true,--}}
{{--        });--}}
{{--    </script>--}}

{{--    @include('shopify-app::partials.token_handler')--}}
{{--    @include('shopify-app::partials.flash_messages')--}}
{{--@endif--}}

</body>
</html>
{{--Footer End--}}
