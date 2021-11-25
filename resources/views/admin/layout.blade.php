<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Experience the difference">
    <meta name="og:image" content="{{asset('assets/images/iwellness_logo_text.png')}}">
    
    <title>@yield('page_header') | iWellness</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(auth()->check())
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0, private" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    @endif
    
    <link rel="apple-touch-icon" href="{{asset('app/classic/base/assets/images/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/iwellness_logo.png')}}">
  
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('app/classic/global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/css/bootstrap-extend.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/base/assets/css/site.min.css')}}">

    <!-- DataTable -->

    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/base/assets/examples/css/tables/datatable.css')}}">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/animsition/animsition.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/asscrollable/asScrollable.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/switchery/switchery.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/intro-js/introjs.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/slidepanel/slidePanel.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/waves/waves.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/jquery-mmenu/jquery-mmenu.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/summernote/summernote.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/alertify/alertify.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/icheck/icheck.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/forms/advanced.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/toastr/toastr.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('app/material/base/assets/css/pages/invoice.css')}}"> -->

    <link rel="stylesheet" href="{{asset('assets/css/custom-admin.css')}}">
    <!-- Fonts -->
    
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/material-design/material-design.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/brand-icons/brand-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/themify/themify.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/font-awesome/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/web-icons/web-icons.min.css')}}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7867618143009870"
     crossorigin="anonymous"></script>
    @yield('style')
    <script src="{{asset('app/classic/global/vendor/breakpoints/breakpoints.js')}}"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  <body class="animsition @yield('body-class') site-navbar-small {{!auth()->check() ? 'pt-0' : ''}}">
  
      @if(auth()->check())
        @include('admin.sidebar')  
        @include('admin.navbar')
      @else
        <a href="{{url('/')}}" class="btn btn-primary m-10">Close</a>
      @endif

      <div class="page">
        @yield('page_title')
        
        <div class="page-content container-fluid">
          <div class="row" data-plugin="matchHeight" data-by-row="true">
            @yield('content')
            
            @if(auth()->check())
              @include('content.modal.profile')
            @endif  
          </div>
        </div>
      </div>  
      @if(auth()->check())   
        @include('content.share-modal')
      @endif  
      
      <footer class="site-footer">
        <div class="site-footer-right">© {{date('Y')}} IWellness</div>
      </footer>
  </body>

  <script src="{{asset('app/classic/global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/popper-js/umd/popper.min.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/animsition/animsition.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/mousewheel/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/ashoverscroll/jquery-asHoverScroll.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/jquery-mmenu/jquery.mmenu.min.all.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/waves/waves.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/toastr/toastr.js')}}"></script>
    <!-- Plugins -->
    <script src="{{asset('app/classic/global/vendor/switchery/switchery.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/intro-js/intro.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/alertify/alertify.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/screenfull/screenfull.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/slidepanel/jquery-slidePanel.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/matchheight/jquery.matchHeight-min.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min.js')}}"></script>
    
    <!-- Scripts -->
    <script src="{{asset('app/classic/global/js/Component.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Base.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Config.js')}}"></script>
    
    <script src="{{asset('app/classic/base/assets/js/Section/Menubar.js')}}"></script>
    <script src="{{asset('app/classic/base/assets/js/Section/GridMenu.js')}}"></script>
    <script src="{{asset('app/classic/base/assets/js/Section/Sidebar.js')}}"></script>
    <script src="{{asset('app/classic/base/assets/js/Section/PageAside.js')}}"></script>
    <script src="{{asset('app/classic/base/assets/js/Plugin/menu.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin/material.js')}}"></script>
    
    <script src="{{asset('app/classic/global/js/config/colors.js')}}"></script>
    <script src="{{asset('app/classic/base/assets/js/config/tour.js')}}"></script>
    
    <!-- Page -->
    <script src="{{asset('app/classic/base/assets/js/Site.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/asscrollable.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/slidepanel.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/switchery.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/matchheight.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/jvectormap.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/peity.js')}}"></script>
    <script src="{{asset('app/classic/global/js/Plugin/icheck.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/summernote/summernote.min.js')}}"></script>

    <script src="{{asset('app/material/base/assets/examples/js/dashboard/v1.js')}}"></script>

    <!-- Datatable -->
    <script src="{{asset('app/classic/global/vendor/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-scroller/dataTables.scroller.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-buttons/dataTables.buttons.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-buttons/buttons.html5.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-buttons/buttons.flash.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-buttons/buttons.print.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-buttons/buttons.colVis.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script src="{{asset('assets/js/share.js')}}"></script>
    <script src="{{asset('assets/js/edit-profile.js')}}"></script>
  
    @stack('scripts')
    
    @if(!empty(monthlySurvey()) && monthlySurvey()->count() != 0 && !auth()->user()->hasanyrole('system administrator'))
        <script>
            toastr.options.onclick = function(){
                window.location.href = '{!! url('res/survey/'.base64_encode(auth()->user()->id)) !!}'
            }
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.info('Click Here!', "Help us to know you better, by answering our monthly survey.")
        </script>
    @endif
</html>    