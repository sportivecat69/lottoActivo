@extends('layouts.app-template')
@section('title', 'Crear Articulo')
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
					<h3 class="box-title">Nuevo Art&iacute;culo</h3>
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
									<form method="POST" action="{{ route('article.store') }}" accept-charset="UTF-8" autocomplete="off">
										{{ csrf_field() }}
										    <div class="row">
										    	<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('categoria') ? ' has-error' : '' }}">
										    			<label>Categor&iacute;a</label>
										    			<select name="categoria" class="form-control">
										    				<option value="">Selecciona Categoria</option>
				    				                       @foreach($categories as $categorie)
				    				                       	<option value="{{$categorie->id}}">{{$categorie->name}}</option>
				    				                       @endforeach
					    				    			</select>
										           		@if ($errors->has('categoria'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('categoria') }}</strong>
						                                    </span>
						                                @endif
										    		</div>
										    	</div>
										    	<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('cod') ? ' has-error' : '' }}">
										            	<label for="codigo">C&oacute;digo</label>
										            	<input type="number" name="cod" id="cod" value="{{ old('cod') }}" class="form-control" placeholder="C&oacute;digo del art&iacute;culo...">
										           		@if ($errors->has('cod'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('cod') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
										            	<label for="nombre">Nombre</label>
										            	<input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Nombre...">
										           		@if ($errors->has('nombre'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('nombre') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('precio_venta') ? ' has-error' : '' }}">
										            	<label for="stock">Precio Tope</label>
										            	<input type="text" name="precio_venta" value="{{ old('precio_venta') }}" class="form-control money" placeholder="Precio venta del art&iacute;culo...">
										           		@if ($errors->has('precio_venta'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('precio_venta') }}</strong>
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
										    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center">
										    		<div class="form-group">
										    			<button type="submit" id="btn-loading" data-loading-text="Cargando..." class="btn btn-primary">
															Guardar
														</button>
										            	<a href="{{ route('article.index') }}" class="btn btn-danger">
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