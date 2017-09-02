@extends('layouts.app-template')
@section('title', 'Editar Categoria')
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
					<h3 class="box-title">Editar Categor&iacute;a: {{ $categorie->name }}</h3>
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
									<form method="POST" action="{{ route('categorie.update', $categorie->id) }}" accept-charset="UTF-8" autocomplete="off">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
											<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
												<label for="nombre">Nombre</label>
												<input type="text" name="name" value="{{ old('name') ? old('name') : $categorie->name }}" class="form-control" placeholder="Nombre...">
											   @if ($errors->has('name'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('name') }}</strong>
				                                    </span>
				                                @endif
											</div>
										</div>
										<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
											<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
												<label for="descripcion">Descripci&oacute;n</label>
												<input type="text" name="description" value="{{ old('name') ? old('name') : $categorie->name }}" class="form-control" placeholder="Descripci&oacute;n...">
											   @if ($errors->has('description'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('description') }}</strong>
				                                    </span>
				                                @endif
											</div>
										</div>
										<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center">
											<div class="form-group">
												<button type="submit" id="btn-loading" data-loading-text="Cargando..." class="btn btn-primary">
													Guardar
												</button>
												<a href="{{ route('categorie.index') }}" class="btn btn-danger">
													Cancelar	
												</a> 
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