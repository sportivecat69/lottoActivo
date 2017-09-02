@extends('layouts.app-template')
@section('title', 'Reportes de Compras')
@section('content')

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
        
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Reportes de Venta</h3>
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
								</div>

								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="table-responsive">
											<table class="table table-striped table-condensed table-hover text-center">
												<thead>
													<th>Factura No.</th>
													<th>Cliente</th>
													<th>Documento</th>
													<th>Tel&eacute;fono</th>
													<th>Fecha</th>
													<th>Detalle</th>
												</thead>
												@php
										            //Agregamos 4 posiciones
										            function formato($c) {
										              printf("%04d<br>", $c);
										            }
												@endphp
												@foreach($reports as $report)
													<tr>
														<td>{{ formato($report->id) }}</td>
														<td>{{ $report->client }}</td>
														<td>{{ $report->doc }}</td>
														<td>{{ $report->phone }}</td>
														<td>{{ date("d-m-Y", strtotime($report->created_at)) }}</td>
														<td>
															<a href="{{ route('sale.invoice', $report->id) }}">
																<i class="fa fa-search fa-lg" aria-hidden="true"></i>
															</a>
														</td>
													</tr>
												@endforeach							
											</table>
											
											{{ $reports->links() }}
											
										</div>
									</div>
								</div>
								<!--Fin Contenido-->
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
</div>
<!--Fin Contenido-->
@endsection
		                          