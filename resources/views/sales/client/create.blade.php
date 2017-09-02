@extends('layouts.app-template')
@section('title', 'Crear Proveedor')
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
					<h3 class="box-title">Nuevo Cliente</h3>
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
									<form method="POST" action="{{ route('client.store') }}" accept-charset="UTF-8" autocomplete="off">
										{{ csrf_field() }}
										    <div class="row">
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('documento') ? ' has-error' : '' }}">
										            	<label for="documento">Documento</label>
										            	<input type="text" name="doc" id="doc" value="{{ old('documento') }}" class="form-control doc" placeholder="Ej: V-12.345.678 o V-12.345.678-9">
										           		@if ($errors->has('documento'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('documento') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
										            	<label for="nombre">Nombre o raz&oacute;n social</label>
										            	<input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Nombre o raz&oacute;n social...">
										           		@if ($errors->has('nombre'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('nombre') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
										    		<div class="form-group  {{ $errors->has('direccion') ? ' has-error' : '' }}">
										            	<label for="descripcion">Direcci&oacute;n</label>
										            	<input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control" placeholder="Direcci&oacute;n del proveedor...">
										           		@if ($errors->has('direccion'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('direccion') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }}">
										            	<label for="stock">Tel&eacute;fono</label>
										            	<input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control phone_us" maxlength="14" placeholder="Tel&eacute;fono del proveedor...">
										           		@if ($errors->has('telefono'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('telefono') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('correo') ? ' has-error' : '' }}">
										            	<label for="stock">Correo</label>
										            	<input type="email" name="correo" value="{{ old('correo') }}" class="form-control" placeholder="Correo del proveedor...">
										           		@if ($errors->has('correo'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('correo') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('estado') ? ' has-error' : '' }}">
										            	<label for="stock">Estado</label>
										            	<div class="radio">
														  <label><input type="radio"  name="estado" value="1">Activo</label>&nbsp;&nbsp;&nbsp;
														  <label><input type="radio"  name="estado" value="0">Inactivo</label>
														</div>
										           		@if ($errors->has('estado'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('estado') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
										    		<div class="form-group  {{ $errors->has('observacion') ? ' has-error' : '' }}">
										            	<label for="descripcion">Observaci&oacute;n</label>
										            	<input type="text" name="observacion" value="{{ old('observacion') }}" class="form-control" placeholder="Observaci&oacute;n del proveedor...">
										           		@if ($errors->has('observacion'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('observacion') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center">
										    		<div class="form-group">
										    			<button type="submit" id="btn-loading" data-loading-text="Cargando..." class="btn btn-primary">
															Guardar
														</button>
										            	<a href="{{ URL::previous() }}" class="btn btn-danger">
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