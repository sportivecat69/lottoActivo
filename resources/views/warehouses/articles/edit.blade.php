@extends('layouts.app-template')
@section('title', 'Editar Articulo')
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
					<h3 class="box-title">Editar Art&iacute;culo: {{ $article->name }}</h3>
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
									<form method="POST" action="{{ route('article.update', $article->id) }}" accept-charset="UTF-8" autocomplete="off">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										    <div class="row">	
										    	<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('cod') ? ' has-error' : '' }}">
										            	<label for="codigo">C&oacute;digo</label>
										            	<input type="number" name="cod" id="cod" value="{{ old('cod') ? old('cod') : $article->cod }}" disabled="disabled" class="form-control" placeholder="C&oacute;digo del art&iacute;culo...">
										           		@if ($errors->has('cod'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('cod') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
										            	<label for="nombre">Nombre</label>
										            	<input type="text" name="nombre"  disabled="disabled" value="{{ old('nombre') ? old('nombre') : $article->name }}" class="form-control" placeholder="Nombre...">
										           		@if ($errors->has('nombre'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('nombre') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('precio_venta') ? ' has-error' : '' }}">
										            	<label for="stock">Limite de venta</label>
										            	<input type="text" name="precio_venta" value="{{ old('precio_venta') ? old('precio_venta') : $article->sale_price }}" class="form-control money" placeholder="Precio venta del art&iacute;culo...">
										           		@if ($errors->has('precio_venta'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('precio_venta') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('estado') ? ' has-error' : '' }}">
										            	<label for="stock">Estado</label>
										            	<div class="radio">
							                                    <label><input type="radio"  name="estado" value="1" {{ $article->status === 1 ? 'checked' : ''}}>Activo</label>&nbsp;&nbsp;&nbsp;
							                                	<label><input type="radio"  name="estado" value="0" {{ $article->status === 0 ? 'checked' : ''}}>Inactivo</label>
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