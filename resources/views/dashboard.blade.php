@extends('layouts.app-template')
@section('title', 'Inicio')
@section('content')

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">

	       <div class="row">
			@if (session('succes'))
	            <div class="alert alert-success alert-dismissable">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
				  {{ session('succes') }}
				</div>
	         @endif
	         
	          @if (session('fail'))
	            <div class="alert alert-danger alert-dismissable">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
				  {{ session('fail') }}
				</div>
	         @endif
	      </div>
	      
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tablero</h3>
                </div>
                <!-- /.box-header -->
	                <div class="box-body">
	                  	<div class="row">
							
							
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--Fin Contenido-->
@endsection
		                   