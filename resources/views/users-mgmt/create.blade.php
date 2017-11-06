@extends('layouts.app-template')
@section('title', 'Crear Usuarios')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    
<div class="container">
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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Crear Usuario</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('usermanagement.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('documento') ? ' has-error' : '' }}">
                            <label for="documento" class="col-md-4 control-label">C&eacute;dula</label>

                            <div class="col-md-6">
                                <input type="text" name="documento" id="doc" value="{{ old('documento') }}" class="form-control doc" placeholder="Ej: V-12.345.678">

                                @if ($errors->has('documento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('documento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('agency') ? ' has-error' : '' }}">
                            <label for="user_level" class="col-md-4 control-label">Agencia</label>

                            <div class="col-md-6">
                            {{ Form::select('agency', [null=>'Seleccione'] + $Agencies, old('agency') or null, array('class' => 'form-control')) }}

                                @if ($errors->has('agency'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('agency') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('printer') ? ' has-error' : '' }}">
                            <label for="user_level" class="col-md-4 control-label">Impresora</label>

                            <div class="col-md-6">
                            {{ Form::select('printer', [null=>'Seleccione'] + $Printers, old('printer') or null, array('class' => 'form-control')) }}

                                @if ($errors->has('printer'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('printer') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('user_level') ? ' has-error' : '' }}">
                            <label for="user_level" class="col-md-4 control-label">Role</label>

                            <div class="col-md-6">
                            {{ Form::select('user_level', $Roles, old('user_level') or null, array('class' => 'form-control', 'readonly'=>'readonly')) }}

                                @if ($errors->has('user_level'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_level') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
						  <strong>El password ser&aacute; igual al n&uacute;mero de c&eacute;dula</strong>
						</div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
				    			<button type="submit" class="btn btn-primary">
									Guardar
								</button>
				            	<a href="{{ route('usermanagement.index') }}" class="btn btn-danger">
									Cancelar	
								</a> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  </div> 	
@endsection

