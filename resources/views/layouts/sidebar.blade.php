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
  		<li class="{{ $url === '/categorie' ? 'active' : ''}}  {{ $url === '/article' ? 'active' : ''}} treeview">
          <a href="#"><i class="fa fa-university " aria-hidden="true"></i> <span>Productos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $url === '/article' ? 'active' : ''}}"><a href="{{ route('article.index') }}">Animalitos</a></li>
<!--             <li class="{{ $url === '/categorie' ? 'active' : ''}}"><a href="{{ route('categorie.index') }}">Categor&iacute;as</a></li> -->
          </ul>
        </li>
  		<li class="{{ $url === '/sale' ? 'active' : ''}}  {{ $url === '/client' ? 'active' : ''}} {{ $url === '/sale/report' ? 'active' : ''}} treeview">
          <a href="#"><i class="fa fa-money " aria-hidden="true"></i> <span>Ventas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $url === '/sale' ? 'active' : ''}}"><a href="{{ route('sale.index') }}">Animalitos</a></li>
<!--             <li class="{{ $url === '/client' ? 'active' : ''}}"><a href="{{ route('client.index') }}">Cliente</a></li> -->
<!--             <li class="{{ $url === '/sale/report' ? 'active' : ''}}"><a href="{{ route('sale.report') }}">Reporte</a></li> -->
          </ul>
        </li>
        <li class="{{ $url === '/user-management' ? 'active' : '' }}">
        	<a href="{{ route('user-management.index') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Usuarios</span></a>
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