@extends('layouts.app-template')
@section('title', 'Cambiar Clave')
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
                <div class="panel-heading">Cambiar Clave</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.update') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Nueva Clave</label>

                            <div class="col-md-6">
                                <input type="text" name="password" value="{{ old('password') }}" class="form-control" placeholder="Nueva.Clv3">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                            <label for="confirm_password" class="col-md-4 control-label">Confirmar Clave</label>

                            <div class="col-md-6">
                                <input type="text" name="confirm_password" value="{{ old('confirm_password') }}" class="form-control" placeholder="Nueva.Clv3">

                                @if ($errors->has('confirm_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif
                            </div>
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
            
            <div class="bs-callout bs-callout-danger" id="callout-buttons-ie-disabled"> 
	            <h4>Nueva Clave: </h4> 
		            <p>Su nueva clave debe contener entre <code>8 a 10</code> caracteres.</p>
		            <p>Sugerimos utilizar al menos una <code>may&uacute;scula</code> un <code>n&uacute;mero</code> y alg&uacute;n caracter especial como <code>.-@,/$*+</code>.</p>
		            <p>La contrase&ntilde;a no debe ser igual a su <code>correo</code> o <code>documento de identidad</code>.</p> 
            </div>
                        
        </div>
    </div>
</div>
  </div> 	
@endsection
<style>
.bs-callout-danger {
    border-left-color: #337ab7;
}
</style>


