@extends('layouts.app-template')
@section('title', 'Categorias')
@section('content')

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
        
         @if (session('status'))
            <div class="alert alert-success alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
			  {{ session('status') }}
			</div>
         @endif
          
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Listado de Categor&iacute;as</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  	<div class="row">
	                  	<div class="col-md-12">
		                      <!--Contenido-->
                              <div class="row">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<form method="GET" action="http://solinperu.com/sisVentas/public/almacen/categoria" accept-charset="UTF-8" autocomplete="off" role="search">
											<div class="form-group">
												<div class="input-group">
													<input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="">
													<span class="input-group-btn">
														<button type="submit" class="btn btn-primary">Buscar</button>
													</span>
												</div>
											</div>
										</form>	
									</div>
<!-- 									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> -->
<!-- 										<a href="{{ route('categorie.create') }}" class="btn btn-success">Nuevo</a> -->
<!-- 									</div> -->
								</div>

								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="table-responsive">
											<table class="table table-striped table-hover text-center">
												<thead>
													<th>#</th>
													<th>Nombre</th>
													<th>Descripci&oacute;n</th>
<!-- 													<th>Editar</th> -->
<!-- 													<th>Eliminar</th> -->
												</thead>
												@php
													$i = 1;
												@endphp
												@foreach($categories as $categorie)
													<tr>
														<td>{{$i}}</td>
														<td>{{ $categorie->name }}</td>
														<td>{{ $categorie->description }}</td>
<!-- 														<td> -->
<!-- 															<a href="{{ route('categorie.edit', $categorie->id) }}"> -->
<!-- 																<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> -->
<!-- 															</a> -->
<!-- 														</td> -->
<!-- 														<td> -->
<!-- 															 <a href="" data-target="#modal-delete-{{$categorie->id}}" data-toggle="modal"> -->
<!-- 															 	<i class="fa fa-times fa-lg" aria-hidden="true"></i> -->
<!-- 															 </a> -->
<!-- 														</td> -->
													</tr>
<!-- 													<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$categorie->id}}"> -->
<!-- 														<form method="POST" action="{{ route('categorie.destroy', $categorie->id) }}" accept-charset="UTF-8"> -->
<!-- 														{{ csrf_field() }} -->
<!-- 														{{ method_field('DELETE') }} -->
<!-- 														<div class="modal-dialog"> -->
<!-- 															<div class="modal-content"> -->
<!-- 																<div class="modal-header"> -->
<!-- 																	<button type="button" class="close" data-dismiss="modal"  -->
<!-- 																	aria-label="Close"> -->
<!-- 													                     <i class="fa fa-times"></i> -->
<!-- 													                </button> -->
<!-- 													                <h4 class="modal-title">Eliminar Categor&iacute;a</h4> -->
<!-- 																</div> -->
																
<!-- 																<div class="modal-body"> -->
<!-- 																	<p>Confirme si desea Eliminar la categor&iacute;a <b>{{ $categorie->name }}</b></p> -->
<!-- 																</div> -->
<!-- 																<div class="modal-footer"> -->
<!-- 																	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
<!-- 																	<button type="submit" class="btn btn-primary">Confirmar</button> -->
<!-- 																</div> -->
																
<!-- 															</div> -->
<!-- 														</div> -->
<!-- 														</form> -->
<!-- 													</div> -->
													@php
														$i++;
													@endphp
												@endforeach							
											</table>
											
											{{ $categories->links() }}
											
										</div>
									</div>
								</div>
								<!--Fin Contenido-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--Fin Contenido-->
@endsection
		                          