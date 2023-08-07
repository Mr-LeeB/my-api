<!DOCTYPE html>
<html lang="en">
<head>
    @include("release::layout.template.head_admin")
    <link href="{{ asset('/theme/base/nova_assets/css/admin-nova.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/theme/base/nova_assets/css/custom.css') }}?version=04082023" rel="stylesheet" type="text/css" />

</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!-- begin:: Header Mobile -->
    @include("release::layout.template.header_mobile_admin")

    <div class="d-flex flex-column flex-root">

		<div class="d-flex flex-row flex-column-fluid page">

            @include("release::layout.template.sidebar_admin")
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" >

                @include("release::layout.template.header_admin")

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    @yield('header_sub')

                    @if (session('message_success') || session('message_error'))
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                @if (session('message_success'))
                                    <div class="d-flex align-items-center bg-light-success rounded p-5 mb-9">
                                        <div class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{!! session('message_success') !!}</div>
                                    </div>
                                @endif
                                @if (session('message_error'))
                                    <div class="d-flex align-items-center bg-light-danger rounded p-5 mb-9">
                                        <div class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{!! session('message_error') !!}...</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex flex-column-fluid">
                        <div class="container-fluid">
                            <div class="row">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>

                @include("release::layout.template.footer_admin")

            </div>
        </div>
      </div>

      @php
          $view_load_theme = 'base';
      @endphp

    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <script type="text/javascript" src="{{ asset('theme/'.$view_load_theme.'/js/plugins.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/'.$view_load_theme.'/js/prismjs.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/'.$view_load_theme.'/js/scripts.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/'.$view_load_theme.'/js/jsutils.js') }}"></script>
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": [
                        "#c5cbe3",
                        "#a1a8c3",
                        "#3d4465",
                        "#3e4466"
                    ],
                    "shape": [
                        "#f0f3ff",
                        "#d9dffa",
                        "#afb4d4",
                        "#646c9a"
                    ]
                }
            }
        };

        $(document).ready(function() {
            // $('.select2').select2({
            //     placeholder: 'Vui lòng chọn option',
            // });

            $("[data-button-type=delete]").click(function(e) {
                e.preventDefault();
                var delete_url = $(this).attr('href');
                if (confirm("Bạn có chắc muốn xóa dữ liệu này?") == true) {
                    window.location.replace(delete_url);
                }
            });
        });
    </script>

    <!-- collapsible menu -->
    <script type="text/javascript">
            // $('.content').css("display","none")
            $('.collapsible').css("cursor","pointer")
            $('.collapsible').on('click',function(){
                var content = $(this)
                content.nextUntil("li.collapsible").slideToggle()
                if(content.hasClass('active')){
                    content.removeClass('active')
                }
                else{
                    content.addClass('active')
                }
            });

    </script>
    <!-- collapsible menu -->

    @yield("javascript")
    @stack('after_script')
</body>
</html>
