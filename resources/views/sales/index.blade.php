@extends('layouts.app-template')
@section('title', 'Gestor de Venta') 
@push('css')
	<style>
		#imaginary_container{
	    margin-top:20%; /* Don't copy this */
		}
		.stylish-input-group .input-group-addon{
		    background: white !important; 
		}
		.stylish-input-group .form-control{
			border-right:0; 
			box-shadow:0 0 0; 
			border-color:#ccc;
		}
		.stylish-input-group button{
		    border:0;
		    background:transparent;
		}
		
		table.lotto-activo  tr  td  img {
		  width: 75px;
		}
		
		/** ESTILOS DE SCROLL DE PRODUCTO**/
		div.list {
		    overflow-x:hidden; 
		    overflow-y:scroll;
            height: 520px;
        }
        
        div.list::-webkit-scrollbar {
            background:#fff;
            width:9px;
        }
        div.list::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
            background-image: -webkit-linear-gradient(top, #3c8dbc 10%,#3c8dbc 51%);
        }
        
        /** ESTILOS DE SCROLL VENTA**/
		div.list-sale {
		    overflow-x:hidden; 
		    overflow-y:scroll;
            height: 445px;
        }
        
        div.list-sale::-webkit-scrollbar {
            background:#fff;
            width:9px;
        }
        div.list-sale::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
            background-image: -webkit-linear-gradient(top, #3c8dbc 10%,#3c8dbc 51%);
        }
        
        .table-condensed>tbody>tr>td,
        .table-condensed>tbody>tr>th, 
        .table-condensed>tfoot>tr>td, 
        .table-condensed>tfoot>tr>th, 
        .table-condensed>thead>tr>td, 
        .table-condensed>thead>tr>th {
            padding: 0px;
        }
        
	</style>
@endpush
@section('content')

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
        
        <!-- ALERT --> 
<!--          @if (session('error')) -->
<!--             <div class="alert alert-danger alert-dismissable"> -->
<!-- 			  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a> -->
<!-- 			  {{ session('error') }} -->
<!-- 			</div> -->
<!--          @endif -->

        <div class="alert alert-danger alert-dismissable status" style="display: none;">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
		  <div id='title-alert'></div>
		</div>
		<!-- END ALERT --> 
        
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <div class="col-md-11">
                  	<h3 class="box-title">Gestor de Ventas </h3>
                  </div>
                  <div class="col-md-1">
              		<div class="text-right">
                        <a data-target="#modal-info" data-toggle="modal" href="#" class="">
                        	<i class="fa fa-info-circle fa-lg" aria-hidden="true" style="color:#367fa9;"></i>
                        </a>
                    </div>
			        <!-- Modal de informacion shortcuts  -->		
					<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-info">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                     <i class="fa fa-times"></i>
					                </button>
					                <h4 class="modal-title">Teclas de acceso r&aacute;pido</h4>
								</div>
								
								<div class="modal-body">
									<div class="shortcut-list-item">
										<h3 class="shortcut-list-item-header">A&ntilde;adir producto a la lista</h3>
										<div class="shortcut-list-item-keys">
											<span class="keyboard-key">ENTER</span>
										</div>
										<div class="short-list-item-desc">
											<p>
												Si pulsa &laquo; enter &raquo;, se a&ntilde;adira el articulo a 
												la lista siempre y cuando estes parado sobre el monto.
											</p>
										</div>
									</div>
									<div class="shortcut-list-item">
										<h3 class="shortcut-list-item-header">Fijar foco en el codigo</h3>
										<div class="shortcut-list-item-keys">
											<span class="keyboard-key">C</span>
										</div>
										<div class="short-list-item-desc">
											<p>
												Si pulsa &laquo; c &raquo;, se fijara el foco en el input del codigo.
											</p>
										</div>
									</div>
									<div class="shortcut-list-item">
										<h3 class="shortcut-list-item-header">Fijar foco en la monto</h3>
										<div class="shortcut-list-item-keys">
											<span class="keyboard-key">M</span>
										</div>
										<div class="short-list-item-desc">
											<p>
												Si pulsa &laquo; m &raquo;, se fijara el foco en el input de monto.
											</p>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
								</div>
								
							</div>
						</div>
					</div>
                  </div>
                </div>
                <!-- /.box-header -->
	                <div class="box-body ">
	                  	<div class="row">
	                  		<div class=" col-md-4 list">
					            <table class="table table-striped table-condensed text-center lotto-activo"> 
				                    <tr>
				                        <td colspan="4">
				                        	<a href="#" onclick="add('0')">
				                        		<img alt="0" src="{{asset('img/animalitos/0.png')}}">
				                        	</a>
				                        	<a href="#" onclick="add('00')">
				                        		<img alt="00" src="{{asset('img/animalitos/00.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                    <tr>
				                    	<td>
    				                    	<a href="#" onclick="add('01')">
    				                      		<img alt="01" src="{{asset('img/animalitos/01.png')}}">
    				                      	</a>
				                      	</td>
				                      	<td>
    				                        <a href="#" onclick="add('02')">
    				                       		<img alt="02" src="{{asset('img/animalitos/02.png')}}">
    				                       	</a>
    				                    </td>				                       
				                        <td>
    				                         <a href="#" onclick="add('03')">
    				                        	<img alt="03" src="{{asset('img/animalitos/03.png')}}">
    				                        </a>
				                        </td>
				                        <td>
				                  			<a href="#" onclick="add('04')">
				                  				<img alt="04" src="{{asset('img/animalitos/04.png')}}">
				                  			</a>
				                  		</td>
				                    </tr>
				                    <tr>
				                        <td>
				                        	<a href="#" onclick="add('05')">
				                        		<img alt="05" src="{{asset('img/animalitos/05.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('06')">
				                        		<img alt="06" src="{{asset('img/animalitos/06.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                    		<a href="#" onclick="add('07')">
				                    			<img alt="07" src="{{asset('img/animalitos/07.png')}}">
				                    		</a>
				                    	</td>
				                    	<td>
				                    		<a href="#" onclick="add('08')">
				                    			<img alt="08" src="{{asset('img/animalitos/08.png')}}">
				                    		</a>
				                    	</td>
				                    </tr>
				                    <tr>
				                    	
				                        <td>
				                        	<a href="#" onclick="add('09')">
				                       			<img alt="09" src="{{asset('img/animalitos/09.png')}}">
				                       		</a>
				                       	</td>
				                       	<td>
				                        	<a href="#" onclick="add('10')">
				                        		<img alt="10" src="{{asset('img/animalitos/10.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('11')">
				                        		<img alt="11" src="{{asset('img/animalitos/11.png')}}">
				                        	</a>
				                        </td>
				                    	<td>
				                    		<a href="#" onclick="add('12')">
				                    			<img alt="12" src="{{asset('img/animalitos/12.png')}}">
				                    		</a>
				                    	</td>
				                    </tr>
				                    <tr>
				                    	<td>
				                    		<a href="#" onclick="add('13')">
				                    			<img alt="13" src="{{asset('img/animalitos/13.png')}}">
				                    		</a>
				                    	</td>
				                        <td>
				                        	<a href="#" onclick="add('14')">
				                        		<img alt="14" src="{{asset('img/animalitos/14.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('15')">
				                        		<img alt="15" src="{{asset('img/animalitos/15.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('16')">
				                        		<img alt="16" src="{{asset('img/animalitos/16.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                   <tr>
				                        <td>
				                        	<a href="#" onclick="add('17')">
				                        		<img alt="17" src="{{asset('img/animalitos/17.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('18')">
				                        		<img alt="18" src="{{asset('img/animalitos/18.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('19')">
				                        		<img alt="19" src="{{asset('img/animalitos/19.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('20')">
				                        		<img alt="20" src="{{asset('img/animalitos/20.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                   <tr>
				                        <td>
				                        	<a href="#" onclick="add('21')">
				                        		<img alt="21" src="{{asset('img/animalitos/21.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('22')">
				                        		<img alt="22" src="{{asset('img/animalitos/22.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('23')">
				                        		<img alt="23" src="{{asset('img/animalitos/23.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('24')">
				                        		<img alt="24" src="{{asset('img/animalitos/24.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                   <tr>
				                        <td>
				                        	<a href="#" onclick="add('25')">
				                        		<img alt="25" src="{{asset('img/animalitos/25.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('26')">
				                        		<img alt="26" src="{{asset('img/animalitos/26.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('27')">
				                        		<img alt="27" src="{{asset('img/animalitos/27.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('28')">
				                        		<img alt="28" src="{{asset('img/animalitos/28.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                   <tr>
				                        <td>
				                        	<a href="#" onclick="add('29')">
				                        		<img alt="29" src="{{asset('img/animalitos/29.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('30')">
				                        		<img alt="30" src="{{asset('img/animalitos/30.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('31')">
				                        		<img alt="31" src="{{asset('img/animalitos/31.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('32')">
				                        		<img alt="32" src="{{asset('img/animalitos/32.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                   <tr>
				                        <td>
				                        	<a href="#" onclick="add('33')">
				                        		<img alt="33" src="{{asset('img/animalitos/33.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('34')">
				                        		<img alt="34" src="{{asset('img/animalitos/34.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('35')">
				                        		<img alt="35" src="{{asset('img/animalitos/35.png')}}">
				                        	</a>
				                        </td>
				                        <td>
				                        	<a href="#" onclick="add('36')">
				                        		<img alt="36" src="{{asset('img/animalitos/36.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
					            </table>
					        </div>
    						<div class=" col-md-8">
								<div class=" col-md-12">
									<div class="col-md-4">
						                <div class="input-group">
						                	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						                    <select id="sorteo" name="sorteo[]" class="selectpicker show-menu-arrow form-control" multiple data-actions-box="true" title="Seleccione Sorteo" data-selected-text-format="count > 2">
                                              @foreach($sorteos as $sorteo)
                                              	@if(date('H') < date('H', strtotime($sorteo->time)))
                                              		<option value="{{ $sorteo->id }}">{{ $sorteo->time }}</option>
                                              	@endif
                                              @endforeach
                                            </select>
					               		</div>
				               		</div>
    								<div class="col-md-3">
						                <div class="input-group">
						                	<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
						                    <input type="text" class="form-control" maxlength="2" onkeydown="keyCode_codigo(event)"  id="codigo" name="codigo"  placeholder="N&uacute;mero" autocomplete="off">
					               		</div>
    								</div>
    								<div class="col-md-5" style=" display: inline-flex;">
						                <div class="input-group col-md-8">
						                	<span class="input-group-addon">Bsf.</span>
						                    <input type="text" class="form-control" onkeydown="keyCode_monto(event)"  id="monto" name="monto"  placeholder="Ingrese Monto" autocomplete="off">
					               		</div>
					               		<div class="col-md-2">
											<a href="#" id="print" onclick="print()" class="btn btn-primary" {{ count($sale_cart) ? '' : 'disabled' }}>
					                        	<i class="fa fa-print" aria-hidden="true"></i>
					                        </a>
					                    </div>
					               		<div class="col-md-2">
											<a data-target="#modal-delete" data-toggle="modal" href="#" id="trash" class="btn btn-danger" {{ count($sale_cart) ? '' : 'disabled' }}>
					                        	<i class="fa fa-trash" aria-hidden="true"></i>
					                        </a>
									        <!-- Modal de confirmacion para vaciar carrito -->		
			       							<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											                     <i class="fa fa-times"></i>
											                </button>
											                <h4 class="modal-title">Borrar Productos</h4>
														</div>
														
														<div class="modal-body">
															<p>Confirme si desea borrar todos</p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
															<a href="{{ route('sale.trash') }}" id="btn-loading" data-loading-text="Cargando..." class="btn btn-primary">
									                        	Confirmar
									                        </a>
														</div>
														
													</div>
												</div>
											</div>
										</div>
    								</div>
								</div>
								<div class=" col-md-12" >
					                <hr>
								</div>
							</div>
							<div class=" col-md-8">
								<div class="list-sale">
    					            <table class="table table-striped table-condensed text-center" id="tabla_product">
    					                <thead>
    					                    <tr>
    					                    	<th>Ruleta</th>
    					                        <th>N&uacute;mero: <span id="jugadas" style="color:#FF0000">{{ count($sale_cart) }}</span></th>
    					                        <th>Sorteo</th>
    					                        <th>Monto</th>
    					                        <th>Total:  <span id="total" style="color:#FF0000">{{ number_format($total,2,",",".") }}</span> </th>
    					                    </tr>
    					                </thead>
    					                <tbody id="add_product">
    					                	@if(count($sale_cart))
    						                	@foreach($sale_cart as $c)
    							                    <tr id="{{ $c->cod }}{{ substr($c->sorteo,0,2) }}">
    							                    	<td><h5>{{ $c->categorie['name'] }}</h5></td>
    							                        <td>
    						                                <h5>{{ $c->cod }} - {{ $c->name }}</h5>
    							                        </td>
    							                        <td>
    						                                <h5>{{ $c->sorteo }}</h5>
    							                        </td>
    							                        <td>
    						                                <h5>{{$c->amount}}</h5>
    							                        </td>
    							                        <td>
    								                        <a href="#" onclick="delete_('{{ $c->cod }}{{ substr($c->sorteo,0,2)}}')">
    								                        	<h5><i class="fa fa-times fa-lg" aria-hidden="true" style="color:#FF0000;"></i></h5>
    								                        </a>
    							                        </td>
    							                    </tr>
    							                @endforeach
    							             @endif
    					                </tbody>
    					            </table>
					            </div>
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
@push('scripts')
	<script>
        $('#codigo').on('input', function () { 
            this.value = this.value.replace(/[^0-9-.]/g,'');
        });

		function add(id) {
		    $('#codigo').val(id);
		    $('#monto').focus().select();
		    return false;
		}

		//Boton loading...
		$("#btn-loading-confirmar").click(function() {
		    var $btn = $(this);
		    $btn.button('loading');
		});

		//funciones con teclado desde codigo
		function keyCode_codigo(event) {
		    var x = event.keyCode;
		    if (x == 13) { // 13 = enter => poner focus en monto
			    $('#monto').focus().select();
		    }
		    
		    if (x == 77) { // 81 = m => focus en el monto
		    	document.getElementById("monto").focus();
		    }

		    if (x == 27) { // 43 = esc => procesar 
				process();
		    }
		}
		
		//funciones con teclado desde monto
		function keyCode_monto(event) {
		    var x = event.keyCode;

		    if (x == 67) { // 67 = c => focus en el codigo
		    	document.getElementById("codigo").focus();
		    }
		    
		    if (x == 13) { // 13 = enter => agregar al carrito
			    var cod = $('#codigo').val();
			    var monto =  $('#monto').val();
			    var sorteo =  $('#sorteo').val();
			    var categorie = 1;
			    if(cod != '' && monto != ''){
				    //validamos si ha selecciondo sorteo
			    	if($('#sorteo').val() != null){
    					$('#codigo').val('');
        			    $('#codigo').focus(); 
        			    
        		    	 $.ajax({
    							url: appRoot + "/sale/add/" + cod ,
        		    	        type: "post",
        		    	        data: { "_token": "{{ csrf_token() }}", categorie: categorie, sorteo: sorteo, cod: cod, amount: monto  } ,
        		    	        success: function (data) {
            		    	        console.log(data);
            		    	        //Validamos si esta abilitado o se excedio el limite
            		    	        if(data != 0 && data != 1) {
                		    	        if(data != 'error') {
                		    	        	$.each(sorteo, function(index){
        //         		    	        		console.log(sorteo[index]);
                		    	        		var cod_ = cod + sorteo[index].substring(0, 2);
                			    	        	//SI EXISTE Y LO REPIREN LO REMUEVE 
                		    	        		$('#'+cod_).remove();
                		    	        		//END
                		    	        		
                    							add_ = '<tr id="'+cod_+'">';
                    							add_ += 	'<td>';
                    							if(categorie == 1){ 
                    								add_ += '<h5>Ruleta Activa<h5>'; 
                        						};
                        						add_ += 	'</td>';
                    							add_ += 	'<td><h5>';
                    							add_ += 		cod + ' - ' +data;
                    							add_ += 	'</h5></td>';
                    							add_ += 	'<td><h5>';
                    							add_ += 		sorteo[index];
                    							add_ += 	'</h5></td>';
                    							add_ += 	'<td><h5>';
                    							add_ += 		monto;
                    							add_ += 	'</h5></td>';
                    							add_ +=   '<td>';
                    							add_ +=    	'<a href="#" onclick="delete_(\''+cod_+'\')">';
                    							add_ +=    		'<h5><i class="fa fa-times fa-lg" aria-hidden="true" style="color:#FF0000;"></i></h5>';
                    							add_ +=    	'</a>';
                    							add_ +=	'</td>'
                    							add_ += '</tr>';
                    							$('#add_product').append(add_);
                		    	        	})
                
                		    	        	//Calcula el monto
                							var total = 0;
                							$('#tabla_product tbody tr').each(function(){
                								total += parseInt($(this).find('td').eq(3).text()||0,10)
                							});
                							$('#total').html(total+',00');
                							//Calculo de Nro. jugadas
                							$('#jugadas').html($('#tabla_product tbody tr').size());
        
        									//Habilito botones
                							$('#trash').attr('disabled', false);
                							$('#print').attr('disabled', false);
                		    	        } else {
                		    	        	location.reload();
                    		    	    }
            		    	        } else if( data == 0 ) {
            		    	        	//Notificacion
            		    	        	$('#title-alert').html('El n&uacute;mero no esta disponible');
              		    			    $('.status').show();
              		    			    setTimeout(function(){ $('.alert').fadeOut(2000) }, 5000); 
            		    	        } else if( data == 1 ) {
            		    	        	//Notificacion
            		    	        	$('#title-alert').html('Se ha excedido el limite de venta');
              		    			    $('.status').show();
              		    			    setTimeout(function(){ $('.alert').fadeOut(2000) }, 5000); 
                    		    	}
        
        		    	        },
        		    	        error: function(jqXHR, textStatus, errorThrown) {
        		    	  		  	//Notificacion
        		    	  		  	$('#title-alert').html('El n&uacute;mero no coincide con ningun registro');
        		    			    $('.status').show();
        		    			    setTimeout(function(){ $('.alert').fadeOut(2000) }, 5000);    
        		    	        }
        		    	    });
    		    	    
    		    	 	return false;
	    	        } else {
		    	        alert('debe seleccionar un sorteo');
		    	    }
			    }else{
				    if(cod == '') {
				    	$('#codigo').focus();
					} else if(monto != '') {
						$('#monto').focus();
					} 
				}
		    }
		    
		    if (x == 27) { // 43 = esc => procesar 
				process();
		    }
		}

		//DELETE
		function print() {
			process();
		}

		//DELETE
		function process() {
			//Valido si hay producto agregados
		    var nFilas = $("#tabla_product tbody tr").length;
			if(nFilas != 0){
				
    		     $.ajax({
        	        url: appRoot + "/sale/process",
        	        type: "post",
        	        data: { _token: "{{csrf_token()}}" },
        	        success: function (data) {
    	    	        $('#add_product').html('')
    	    	        
    					$('#total').html('0,00');
    					//Calculo de Nro. jugadas
    					$('#jugadas').html('0');
    					
    					$('#codigo').val('');
    					$('#monto').val('');
        			    $('#codigo').focus();               
        	        },
        	        error: function(jqXHR, textStatus, errorThrown) {
        	           console.log(textStatus, errorThrown);
        	        }
        	    });

			} else {
				alert('No hay productos agregados');
			}
	    }

		//DELETE
		function delete_(id) {
	    	 $.ajax({
    	        url: appRoot + "/sale/delete/" + id,
    	        type: "get",
    	        success: function (data) {
	    	        $('#'+id).remove()
	    	        
    	        	//Calcula el monto
					var total = 0;
					$('#tabla_product tbody tr').each(function(){
						total += parseInt($(this).find('td').eq(3).text()||0,10)
					});
					$('#total').html(total+',00');
					//Calculo de Nro. jugadas
					$('#jugadas').html($('#tabla_product tbody tr').size());
						
    			    $('#codigo').focus();  

    			  //Inhabilito el boton de borrar todo
    			    var nFilas = $("#tabla_product tbody tr").length;
					if(nFilas == 0){
						$('#trash').attr('disabled', true);
						$('#print').attr('disabled', true);
					}             
    	        },
    	        error: function(jqXHR, textStatus, errorThrown) {
    	           console.log(textStatus, errorThrown);
    	        }
    	    });
	    }

	</script>
@endpush
		                          