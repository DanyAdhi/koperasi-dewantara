<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard - Koperasi</title>

    <meta name="description" content="" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">


    <!-- Helpers -->
    <script src="{{asset('js/helpers.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu -->
        @include('layouts.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
          
          <!-- Navbar -->
          @include('layouts.navbar')

          <!-- Content wrapper -->
          <div class="content-wrapper">            
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">
                @yield('breadcrumb')
              </h4>
              <!-- Content -->
              @yield('content')  
            </div>
          </div>
          <!-- Content wrapper -->
          
          <!-- Footer -->
          @include('layouts.footer')

        </div>
        <!-- / Layout page -->
        
      </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{asset('libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    
    <script src="{{asset('js/menu.js')}}"></script>
    <!-- endbuild -->
    
    <!-- Vendors JS -->
    <script src="{{asset('libs/apex-charts/apexcharts.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    
    <!-- Main JS -->
    <script src="{{asset('js/main.js')}}"></script>
    
    <!-- Page JS -->
    <script src="{{asset('js/dashboards-analytics.js')}}"></script>
    
    
    @yield('script')
    <script>
      function deleteConfirm(url) {
        $('#hapus').attr('action',url);
      }
    </script>
  </body>
</html>
