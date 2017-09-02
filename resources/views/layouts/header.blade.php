<?php use App\Article; ?>
  <!-- Main Header -->
  <header class="main-header" style="position:fixed;width: 100%;">
  
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo" style="display: none;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
<!--       	<b>T</b>&<b>T</b> -->
			<img alt="T&T" src="{{ asset('img/favicon.png') }}" width="50px">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Innovaciones</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="display: none;">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
			<!-- NOTIFICATION -->
			@php
	       		/* Notificaciones de stok */
            	$articles = Article::all();
            	
            	foreach($articles as $article) {
            		$notification = Article::where([
            										['stok_min', '>=', $article->stok],
            										['status', 1]
            									])->get();
            	};
	                        		
            	$num_notificaciones = count($notification);
	        @endphp
			<li class="dropdown" style="margin-bottom: -5px; ">
               <!-- Sub Menu 1 -->
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-bottom: 10px;" role="button" aria-expanded="false">
                 <span class="glyphicon glyphicon-bell" style="font-size: 18px; margin-top:1px"></span>
                 @if($num_notificaciones !== 0)
                   <span class="badge bg-green">{{ $num_notificaciones }}</span>
                 @endif
               </a>

                <ul class="dropdown-menu notificaciones" role="menu">
                @if($num_notificaciones !== 0)
                  @foreach($notification as $article)
			      	<li>
				      <a href="#">
							<span>
							<span>{{ $article->name }}</span>
							<span class="time">Cod: {{ $article->cod }}</span>
							</span>
							<span class="message">
								Dispinible en stok <b> ( {{ $article->stok }} )</b>. Realizar compra para aumentarel stok.
							</span>
						</a>
                    </li>
                  @endforeach
                @else
                    <li>
                       <a href="#">
							<span class="message" style="margin-left: 45px;">
								<b>No hay notificaciones para mostrar</b>	
							</span>
						</a>
                    </li> 
                @endif       		
                </ul>
            </li>
	        <!-- NOTIFICATION -->      
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">

                <p>
                  Hello {{ Auth::user()->firstname.' '.Auth::user()->lastname }}	
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
               @if (Auth::guest())
                  <div class="pull-left">
                    <a href="{{ route('login') }}" class="btn btn-default btn-flat">Login</a>
                  </div>
               @else
                 <div class="pull-left">
                    <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Perfil</a>
                  </div>
                 <div class="pull-right">
                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Salir
                    </a>
                 </div>
                @endif
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
   </form>