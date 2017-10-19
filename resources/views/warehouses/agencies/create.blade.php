@extends('layouts.app-template')
@section('title', 'Crear Agencia')
@section('content')

<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
					<h3 class="box-title">Nueva Agencia</h3>
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
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<form method="POST" action="{{ route('agency.store') }}" accept-charset="UTF-8" autocomplete="off">
										{{ csrf_field() }}
										    <div class="row">
										    	<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
										            	<label for="nombre">Nombre</label>
										            	<input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nombre...">
										           		@if ($errors->has('name'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('name') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
										            	<label for="description">Descripci&oacute;n</label>
										            	<input type="text" name="description" value="{{ old('description') }}" class="form-control" placeholder="Ej:Direccion...">
										           		@if ($errors->has('description'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('description') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('percentage_gain') ? ' has-error' : '' }}">
										            	<label for="percentage_gain">Porcentaje de Ganancia</label>
										            	<input type="text" name="percentage_gain" id="cod" value="{{ old('percentage_gain') }}" class="form-control" placeholder="Ej:15,00...">
										           		@if ($errors->has('percentage_gain'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('percentage_gain') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('num_cajas') ? ' has-error' : '' }}">
										            	<label for="num_cajas">N&uacute;mero de cajas</label>
										            	<input type="number" name="num_cajas" value="{{ old('num_cajas') }}" class="form-control money" placeholder="Ej:2...">
										           		@if ($errors->has('num_cajas'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('num_cajas') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('mint_sell') ? ' has-error' : '' }}">
										            	<label for="stock">Minutos para Vender</label>
										            	<input type="number" name="mint_sell" value="{{ old('mint_sell') }}" class="form-control money" placeholder="Ej:10...">
										           		@if ($errors->has('mint_sell'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('mint_sell') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('mint_cancel') ? ' has-error' : '' }}">
										            	<label for="stock">Minutos para Cancelar</label>
										            	<input type="number" name="mint_cancel" value="{{ old('mint_cancel') }}" class="form-control money" placeholder="Ej:10...">
										           		@if ($errors->has('mint_cancel'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('mint_cancel') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center">
										    		<div class="form-group">
										    			<button type="submit" id="btn-loading" data-loading-text="Cargando..." class="btn btn-primary">
															Guardar
														</button>
										            	<a href="{{ route('agency.index') }}" class="btn btn-danger">
															Cancelar	
														</a> 
										            </div>
										    	</div>
										    </div>
										</form>
									
									</div>
								</div>
							<!--Fin Contenido-->
							</div>
						</div>
					
					</div>
				</div><!-- /.row -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
@endsection
@push('scripts')

@endpush