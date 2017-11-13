@extends('layouts.app-template')
@section('title', 'Usuario')
@section('content')


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
     <div class="row">
      <div class="col-md-12">
		 <div class="jumbotron text-center">
			<h2>{{ $user->fistname }}</h2>
			<p>
				<strong>Documento:</strong> {{ $user->documento }}<br>
				<strong>Email:</strong> {{ $user->email }}<br>
				<strong>Level:</strong> @foreach ($user->rol as $rol){{ $rol->display_name }}	@endforeach <br>
				<strong>Agencia:</strong> {{ $user->seller_agency->agency->name }} <br>
				<strong>Impresora:</strong> {{ $user->seller_agency->agency->name }} <br>
				<a href="{{ route('password.change') }}"><i class="fa fa-key text-warning"></i>Cambiar Clave</a>

			</p>
		</div>     
      </div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--Fin Contenido-->
@endsection