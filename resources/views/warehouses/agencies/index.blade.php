@extends('layouts.app-template')
@section('title', 'Agencias')
@section('content')

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
        
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
          
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">
					Listado de Agencias 
				  </h3>
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
										<form method="GET" action="" accept-charset="UTF-8" autocomplete="off" role="search">
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
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
										<a href="{{ route('agency.create') }}" class="btn btn-success">Nuevo</a>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="table-responsive">
											<table class="table table-striped table-condensed table-hover text-center">
												<thead>
													<th>Nombre</th>
													<th>Descripci&oacute;n</th>
													<th>Porcentaje de Ganancia</th>
													<th>N&uacute;mero de cajas</th>
													<th>Minutos para Vender</th>
													<th>Minutos para Cancelar</th>
													<th>Estatus</th>
													<th>Opciones</th>
												</thead>
												@foreach($agencies as $agency)
													<tr>
														<td>{{ $agency->name }}</td>
														<td>{{ $agency->description }}</td>
														<td>{{ number_format($agency->percentage_gain,2,",",".") }}</td>
														<td>{{ $agency->num_cajas }}</td>
														<td>{{ $agency->mint_sell }}</td>
														<td>{{ $agency->mint_cancel }}</td>
														<td>
															@if($agency->status === true)
																<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color:#68D332;"></i>
															@else
																<i class="fa fa-minus-circle fa-lg" aria-hidden="true" style="color:#FF0000;"></i>
															@endif
														</td>
														<td>
															@if($agency->status === true)
																<a href="{{ route('agency.show', $agency->id) }}">
																	<i class="fa fa-eye fa-lg" aria-hidden="true"></i>
																</a>
																<a href="{{ route('agency.edit', $agency->id) }}">
																	<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
																</a>
																<a href="" data-target="#modal-delete-{{$agency->id}}" data-toggle="modal">
																	 	<i class="fa fa-toggle-off fa-lg" aria-hidden="true"></i>
		 														</a
	 														@else
		 														<a href="" data-target="#modal-activate-{{$agency->id}}" data-toggle="modal">
																	 	<i class="fa fa-toggle-on fa-lg" aria-hidden="true"></i>
		 														</a
	 														@endif
	 														
														</td>

<!-- 													</tr> -->
													<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$agency->id}}">
														<form method="POST" action="{{ route('agency.destroy', $agency->id) }}" accept-charset="UTF-8">
														{{ csrf_field() }}
														{{ method_field('DELETE') }}
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" 
																	aria-label="Close">
													                     <i class="fa fa-times"></i>
													                </button>
													                <h4 class="modal-title">Inactiva Agencia</h4>
																</div>
																
																<div class="modal-body">
																	<p>Confirme si desea inactivar <b>{{ $agency->name }}</b></p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																	<button type="submit" class="btn btn-primary">Confirmar</button>
																</div>
																
															</div>
														</div>
														</form>
													</div>
													<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-activate-{{$agency->id}}">
														<form method="POST" action="{{ route('agency.activate', $agency->id) }}" accept-charset="UTF-8">
														{{ csrf_field() }}
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" 
																	aria-label="Close">
													                     <i class="fa fa-times"></i>
													                </button>
													                <h4 class="modal-title">Activar Agencia</h4>
																</div>
																
																<div class="modal-body">
																	<p>Confirme si desea Activar <b>{{ $agency->name }}</b></p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																	<button type="submit" class="btn btn-primary">Confirmar</button>
																</div>
																
															</div>
														</div>
														</form>
													</div>
												@endforeach							
											</table>
											
											{{ $agencies->links() }}
											
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
		                          