@extends('layouts.app-template')
@section('title', 'Crear Agencia')
@section('content')

<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content">
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
	<form method="POST" action="{{ route('agency.store') }}" accept-charset="UTF-8" autocomplete="off" id="agency-form">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-warning">
					<div class="box-header with-border">
					<h3 class="box-title">Datos de la nueva Agencia</h3>

					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
							<!--Contenido-->
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
										{{ csrf_field() }}
										    <div class="row">
										    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 ">
										    		<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
										            	<label for="nombre">Nombre</label>
										            	<input type="text" name="name" value="{{ old('name') }}" class="form-control validation-required" placeholder="Nombre...">
										           		@if ($errors->has('name'))
						                                    <span class="help-block">
						                                        <strong>{{ $errors->first('name') }}</strong>
						                                    </span>
						                                @endif
										            </div>
										    	</div>
										    	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 ">
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
										            	<input type="text" name="percentage_gain" id="cod" value="{{ old('percentage_gain') }}" class="form-control money" placeholder="Ej:15,00...">
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
										    	
										    </div>
										
									
									</div>
								</div>
							<!--Fin Contenido-->
							</div>
						</div>
					
					</div>
				</div><!-- /.row -->
			</div><!-- /.box-body -->
		
		
		
	
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Loterias a Vender</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
              
              	<div class="panel panel-default">
                <!-- Default panel contents -->
                
            
                <!-- List group -->
                <ul class="list-group">
                    @foreach($categories as $categorie)
                    <li class="list-group-item">
                        {{ $categorie->name }}
                        <div class="material-switch pull-right">
                            <input id="categorie-<?php echo $categorie->id;?>" name="categorie[<?php echo $categorie->id;?>][on]" type="checkbox"  <?php if(old('categorie.'.$categorie->id.'.on')=='on'): echo 'checked'; else: echo ''; endif; ?> onclick="$('#collapse'+<?php echo $categorie->id;?>).slideToggle('slow');"/>
                            <label for="categorie-<?php echo $categorie->id;?>" class="label-success"></label>
                        </div>
                        <div  class="collapse" id="collapse<?php echo $categorie->id;?>">
							  <div class="well">
							   						<div class="form-group <?php echo $errors->has('bet_min-'.$categorie->id) ? ' has-error' : '' ?>">
										            	<label for="prize_min">Apuesta M&iacute;nima</label>
										            	<input type="text" id="categorie[<?php echo $categorie->id;?>][bet_min]" name="categorie[<?php echo $categorie->id;?>][bet_min]" value="<?php echo old('categorie.'.$categorie->id.'.bet_min') ?>" class="form-control money" placeholder="Ej:100...">
										           		<?php if($errors->has('bet_min-'.$categorie->id)): ?>
						                                    <span class="help-block">
						                                        <strong><?php  echo $errors->first('bet_min-'.$categorie->id) ?></strong>
						                                    </span>
						                                <?php endif;?>
										            </div>
										            <div class="form-group <?php echo $errors->has('prize_min-'.$categorie->id) ? ' has-error' : '' ?>">
										            	<label for="prize_min">Pago M&iacute;nimo</label>
										            	<input type="text" id="categorie[<?php echo $categorie->id;?>]['prize_min']" name="categorie[<?php echo $categorie->id;?>][prize_min]" value="<?php echo old('categorie.'.$categorie->id.'.prize_min') ?>" class="form-control money" placeholder="Ej:100...">
										           		<?php if($errors->has('prize_min-'.$categorie->id)): ?>
						                                    <span class="help-block">
						                                        <strong><?php  echo $errors->first('prize_min-'.$categorie->id) ?></strong>
						                                    </span>
						                                @endif
										            </div>
							  </div>
                        </div>
                    </li>
                   @endforeach
                    
                </ul>
            </div> 
              	
                
              </div>
              <!-- /.box-body -->

          </div>
          <!-- /.box -->
		</div>
		
		</div><!-- /.box -->
          
        <div class="row">
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

	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
@endsection
@push('scripts')
<script type="text/javascript">

$(document).ready(function() {

  
        $('#agency-form input[type=checkbox]').each(function(){
            if (this.checked) {
            	var id = $(this).attr("id");
            	var d = id.split('-');
            	$("#collapse"+d[1]).slideToggle("slow");
            }
        }); 

      
});
// 	function formConf(id){
// 		//alert(id);
		
// 		//alert($("#categorie"+id+":checked").val());
		
// 		//$("#collapse"+id).slideToggle( "slow");
// 		if($("#categorie"+id+":checked").val()=='on'){
// 			$("#collapse"+id).slideToggle( "slow");
// 		}else{
// 			alert('dont');
// 		}
// 	}




</script>
@endpush

<style>

.material-switch > input[type="checkbox"] {
    display: none;   
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
}
</style>

