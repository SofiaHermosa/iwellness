
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Experience the difference">
    <meta name="og:image" content="{{asset('assets/images/iwellness_logo_text.png')}}">
    <meta name="author" content="">
    
    <title>@yield('page_title') | iWellness</title>
    
    <link rel="apple-touch-icon" href="{{asset('assets/images/iwellness_logo.png')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/iwellness_logo.png')}}">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('app/material/global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/css/bootstrap-extend.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/base/assets/css/site.min.css')}}">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/animsition/animsition.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/asscrollable/asScrollable.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/switchery/switchery.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/intro-js/introjs.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/slidepanel/slidePanel.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/flag-icon-css/flag-icon.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/waves/waves.css')}}">
        <link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/pages/login-v2.css')}}">
    
    
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('app/material/global/fonts/material-design/material-design.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/fonts/brand-icons/brand-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/web-icons/web-icons.min.css')}}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="{{asset('app/material/global/vendor/html5shiv/html5shiv.min.js')}}"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="{{asset('app/material/global/vendor/media-match/media.match.min.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/respond/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('assets/css/custom-admin.css')}}">
    <!-- Scripts -->
    <script src="{{asset('app/material/global/vendor/breakpoints/breakpoints.js')}}"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  <body class="animsition page-login-v2 layout-full page-dark">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
      <div class="page-content">
        <div class="page-brand-info">
          <div class="brand">
            <img class="brand-img" width="150" height="150" src="{{asset('assets/images/iwellness_logo.png')}}" alt="...">
            <h2 class="brand-text font-size-60 text-warning">iWellness<br> 
              <small class="font-size-18 p-0">Experience the Difference.</small>
            </h2>
            
          </div>
        </div>

        <div class="page-login-main">
          <div class="brand hidden-md-up">
            <img class="brand-img" width="100" height="100" src="{{asset('assets/images/iwellness_logo.png')}}" alt="...">
            <h3 class="brand-text font-size-40 text-warning">iWellness</h3>
          </div>
          <h3 class="font-size-24">@yield('page_title')</h3>
          <p></p>

          @yield('content')

          <footer class="page-copyright">
            <p>iWellness</p>
            <p>© {{date('Y')}}. All RIGHT RESERVED.</p>
            {{-- <div class="social">
              <a class="btn btn-icon btn-round social-twitter mx-5" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
              <a class="btn btn-icon btn-round social-facebook mx-5" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
              <a class="btn btn-icon btn-round social-google-plus mx-5" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
            </div> --}}
          </footer>
        </div>

      </div>
    </div>
    <!-- End Page -->


    <!-- Core  -->
    <script src="{{asset('app/material/global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/popper-js/umd/popper.min.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/animsition/animsition.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/mousewheel/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/ashoverscroll/jquery-asHoverScroll.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/waves/waves.js')}}"></script>
    
    <!-- Plugins -->
    <script src="{{asset('app/material/global/vendor/switchery/switchery.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/intro-js/intro.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/screenfull/screenfull.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/slidepanel/jquery-slidePanel.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
    
    <!-- Scripts -->
    <script src="{{asset('app/material/global/js/Component.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin.js')}}"></script>
    <script src="{{asset('app/material/global/js/Base.js')}}"></script>
    <script src="{{asset('app/material/global/js/Config.js')}}"></script>
    
    <script src="{{asset('app/material/base/assets/js/Section/Menubar.js')}}"></script>
    <script src="{{asset('app/material/base/assets/js/Section/GridMenu.js')}}"></script>
    <script src="{{asset('app/material/base/assets/js/Section/Sidebar.js')}}"></script>
    <script src="{{asset('app/material/base/assets/js/Section/PageAside.js')}}"></script>
    <script src="{{asset('app/material/base/assets/js/Plugin/menu.js')}}"></script>
    
    <script src="{{asset('app/material/global/js/config/colors.js')}}"></script>
    <script src="{{asset('app/material/base/assets/js/config/tour.js')}}"></script>
    <script>Config.set('assets', '../../assets');</script>
    
    <!-- Page -->
    <script src="{{asset('app/material/base/assets/js/Site.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin/asscrollable.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin/slidepanel.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin/switchery.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin/jquery-placeholder.js')}}"></script>
    <script src="{{asset('app/material/global/js/Plugin/material.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('assets/js/register.js')}}"></script>
    <script src="{{asset('assets/js/validate-pass.js')}}"></script>
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
    
  </body>
</html>
