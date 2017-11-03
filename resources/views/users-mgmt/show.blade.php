@extends('layouts.app-template')
@section('title', 'Usuario')
@section('content')


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
     <div class="row">
      <div class="col-md-12">
		      <!-- Default box -->
		      <div class="box box-warning">
		        <div class="box-header with-border">
		          <h3 class="box-title">Usuario: {{ $user->lastname.' '.$user->firstname }}</h3>
		
<!-- 		          <div class="box-tools pull-right"> -->
<!-- 		            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"> -->
<!-- 		              <i class="fa fa-minus"></i></button> -->
<!-- 		          </div> -->
		        </div>
		        <div class="box-body"> 
		              <table class="table table-bordered">          
			                <tr><th>C&eacute;dula</th><td>{{ $user->documento }}</td></tr>
							<tr><th>Correo</th><td>{{ $user->email }}</td></tr>
							<tr><th>Rol</th><td> @foreach ($user->rol as $rol){{ $rol->display_name }}	@endforeach </td></tr>
							<tr><th>Estatus</th><td>{{ empty($user->deleted_at) ? 'ACTIVO' : 'INACTIVO' }}</td></tr>

							<tr><th>Agencia</th><td>...</td></tr>
		              </table>
		        </div>
		        <!-- /.box-body -->
		        <div class="box-footer">
		          ...
		        </div>
		        <!-- /.box-footer-->
		      </div>
		      <!-- /.box -->
      	</div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--Fin Contenido-->
@endsection