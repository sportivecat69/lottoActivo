<!DOCTYPE html>
<!--
  This is a starter template page. Use this page to start your new project from
  scratch. This page gets rid of all links and provides the needed markup only.
  -->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap 3.3.6 -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css")}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
      -->
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/jvectormap/jquery-jvectormap.css")}}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('css/app-template.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="{{ asset("/css/bootstrap-select.css") }}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @stack('css')
    <style type="text/css">
        .alert {
            height:50px;
            width: 94%;
            z-index: 999;
            position: absolute;
        }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">

	  
    <div class="wrapper">
    <!-- Main Header -->
<!--    include('layouts.header') -->
    <!-- Sidebar -->
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="position: fixed;">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="margin-top: -35px;">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" data-toggle="offcanvas" style="cursor: pointer;">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          <a href="{{ route('profile') }}"><i class="fa fa-cog text-warning"></i>Settings</a>
        </div>
      </div>

      <!-- search form (Optional) -->
<!--       <form action="#" method="get" class="sidebar-form"> -->
<!--         <div class="input-group"> -->
<!--           <input type="text" name="q" class="form-control" placeholder="Search..."> -->
<!--               <span class="input-group-btn"> -->
<!--                 <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> -->
<!--                 </button> -->
<!--               </span> -->
<!--         </div> -->
<!--       </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
      	@php
      		$url = str_replace(url('/'), "", url()->current());
      	@endphp
        <!-- Optionally, you can add icons to the links -->
        <li class="{{ $url === '' ? 'active' : '' }}"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg" aria-hidden="true"></i> <span>Inicio</span></a></li>
        <li class="{{ $url === '' ? 'active' : '' }}"><a href="{{ route('index.seller') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Resumen del d&iacute;a</span></a></li>
  		<li class="{{ $url === '/categorie' ? 'active' : ''}}  {{ $url === '/article' ? 'active' : ''}} treeview">
          <a href="#"><i class="fa fa-shopping-bag " aria-hidden="true"></i> <span>Productos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $url === '/article' ? 'active' : ''}}"><a href="{{ route('article.index', 1) }}">Lotto Activo</a></li>
	        <li class="{{ $url === '/article' ? 'active' : ''}}"><a href="{{ route('article.index', 2) }}">La Granjita</a></li>
          </ul>
        </li>
  		<li class="{{ $url === '/sale' ? 'active' : ''}}  {{ $url === '/client' ? 'active' : ''}} {{ $url === '/sale/report' ? 'active' : ''}} treeview">
          <a href="#"><i class="fa fa-ticket " aria-hidden="true"></i> <span>Ventas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 1) }}">Lottoactivo</a></li>
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 2) }}">Granjita</a></li>
<!--             <li class="{{ $url === '/sale/report' ? 'active' : ''}}"><a href="{{ route('sale.report') }}">Reporte</a></li> -->
          </ul>
        </li>
        <li class="{{ $url === '/agency' ? 'active' : '' }}">
        	<a href="{{ route('agency.index') }}"><i class="fa fa-university" aria-hidden="true"></i> <span>Agencias</span></a>
        </li>
        <li class="{{ $url === '/sale' ? 'active' : ''}}  {{ $url === '/client' ? 'active' : ''}} {{ $url === '/sale/report' ? 'active' : ''}} treeview">
          <a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('chart.sold') }}">Ventas</a></li>
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 2) }}">Tickets</a></li>
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 2) }}">Premios</a></li>
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 2) }}">Pagos Realizados</a></li>
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 2) }}">Pagos Pendientes</a></li>
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index', 2) }}">Utilidad</a></li>
          </ul>
        </li>
        <li class="{{ $url === '/user-management' ? 'active' : '' }}">
        	<a href="{{ route('usermanagement.index') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Usuarios</span></a>
        </li>
        <li>
        	<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        		<i class="fa fa-power-off" aria-hidden="true"></i> <span>Salir</span>
        	</a>
		   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		      {{ csrf_field() }}
		   </form>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  
    @yield('content')
    <!-- /.content-wrapper -->
    <!-- Footer -->
  <!-- Main Footer -->
<!--   <footer class="main-footer" > -->
    <!-- To the right -->
<!--     <div class="pull-right hidden-xs"> -->
<!--      	Version 1.0 -->
<!--     </div> -->
    <!-- Default to the left -->
<!--     <strong>Copyright &copy; 2017-{{ date('Y') }}, <a href="#">Innovaciones Tecnologicas T&T, C.A</a>.</strong> Todos los derechos reservados. -->
<!--   </footer> -->
    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery 2.1.3 -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/fastclick/fastclick.js") }}" type="text/javascript" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js") }}" type="text/javascript" ></script>
    <script  src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}" type="text/javascript" ></script>
    <!-- AdminLTE App -->
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/demo.js") }}" type="text/javascript"></script>
    <!-- ChartJS -->
	<script src="{{ asset ("/bower_components/AdminLTE/dist/js/Chart.js") }}" type="text/javascript"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/dist/js/jvectormap/jquery-jvectormap-1.2.2.min.js") }}" type="text/javascript"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/dist/js/jvectormap/jquery-jvectormap-world-mill-en.js") }}" type="text/javascript"></script>
	<!-- jvectormap  -->
	<script src="{{ asset ("/bower_components/AdminLTE/dist/js/jquery-sparkline/jquery.sparkline.min.js") }}" type="text/javascript"></script>
	<!-- Sparkline -->
    <script src="{{ asset ("/js/bootstrap-select.js") }}" type="text/javascript"></script>
    <script>var appRoot = '{{ url("/") }}'</script> 
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
      <script>
		$(document).ready(function() {
			setTimeout(function(){ $('.alert').fadeOut(1000) }, 5000);
		});

		//Boton loading...
		$("#btn-loading").click(function() {
		    var $btn = $(this);
		    $btn.button('loading');
// 		    // simulating a timeout
// 		    setTimeout(function () {
// 		        $btn.button('reset');
// 		    }, 1000);
		});
		
      $(document).ready(function() {
        //Date picker
        $('#birthDate').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#hiredDate').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#from').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
        $('#to').datepicker({
          autoclose: true,
          format: 'yyyy/mm/dd'
        });
    });
	</script>
	
	<script src="{{ asset("js/mask.min.js") }}"></script>
    <script type="text/javascript">
	    $(document).ready(function(){
	    	  $('.phone_us').mask('(000) 000-0000');
	    	  $('.money').mask("000.000.000.000.000,00", {reverse: true});
	    	  $('.doc').mask('S-00.000.000-0', {'translation': {
												                  S: {pattern: /[V,E,J,G]/}
													                }
													          });
	    });
    </script>

	@stack('scripts')

  </body>
</html>