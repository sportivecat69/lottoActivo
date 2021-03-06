@extends('layouts.app-template')
@section('title', 'Gestor de Venta') 
@push('css')
<?php 
use Carbon\Carbon;

/*
$date = '17:00'; // lo que obtienes del sorteo


$tickets = \DB::table('sales')
->where('created_at','>=', Carbon::parse($date)->subHour(1))  // desde las 16:00
->where('created_at','<=', Carbon::parse($date))  // hasta las 17:00
->where('status','<>', 'ANULADO') // NO SE CONSIDERAN LOS ANULADOS
->get();

// $sales=App\Sale::where([
		
// 		['created_at','>=', Carbon::parse($date)->subHour(1)], 
// 		['created_at','<=', Carbon::parse($date)],
// 		['status','<>', 'ANULADO']
		
// ])->get();

// esto retorna todas las jugadas de hoy entre las 4pm y 5pm 
dd($tickets); die();   

*/

/***
 * PERO ESTO NOS NOS SIRVE JAJAJAJAJAJAJAJA
 * PORQUE YO PUEDO JUGAR EL SORTEO DE LAS 5 A LA 1PM 
 * ASI QUE LA MANERA CORRECTA ES TRAER TODAS LAS JUGADAS DE HOY QUE HAY PARA UN SORTEO ESPESIFICO
 * 
 * 
 * 
 */
// aqui falta filtro de la agencia que te la tienes que traer por los id de sales_invoices
// $ventas = \DB::table('sales')
// ->select(\DB::raw("SUM(bet) as ventas"))
// ->where('created_at','>=', Carbon::today())
// ->where('created_at','<=', Carbon::today()->addDay(1))
// ->where('status','<>', 'ANULADO') // NO SE CONSIDERAN LOS ANULADOS
// ->where('articles_id', 1) // filtro por articulo
// ->where('draws_id', 2)  // filtro por sorteo
// ->get();

// dd($ventas[0]->ventas); die();

?>
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
         @if (session('error'))
            <div class="alert alert-danger alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
			  {{ session('error') }}
			</div>
         @endif
         
		@if (session('success'))
            <div class="alert alert-success alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
			  {{ session('success') }}
			</div>
         @endif

        <div class="alert alert-danger alert-dismissable status" style="display: none;">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
		  <div id='title-alert'></div>
		</div>
		<!-- END ALERT --> 
        
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
<!--                  <div class="col-md-2"> -->
<!--                       <div class="col-md-1"> -->
<!--                       	<a data-target="#modal-info" data-toggle="modal" href="#" class=""> -->
                      <!-- <i class="fa fa-info-circle fa-lg" aria-hidden="true" style="color:#367fa9;"></i> -->    
<!--                         </a> -->
<!--                       </div> -->
<!--                   </div> -->
                  <!-- BTN Anular y Pagar  -->	
                  <div class="col-md-12">
               		
					<div class="col-md-4">
		                <div class="input-group">
		                	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
		                    <select id="sorteo" name="sorteo[]" class="selectpicker show-menu-arrow form-control" multiple data-actions-box="true" title="Seleccione Sorteo" data-selected-text-format="count > 2">
                              @foreach($sorteos as $sorteo)
                                @php
                                	 $horaVenta = strtotime ( '-'.$mint_sell.' minute' , strtotime ( date( 'H:i', strtotime($sorteo->time)) ) ) ;
                                @endphp
                              	@if(date('H:i') < date('H:i', $horaVenta))
                              		<option value="{{ $sorteo->id }}" id='{{ $sorteo->id }}'>{{ $sorteo->categorie->name }} - {{ $sorteo->time }}</option>
                              	@endif
                              @endforeach
                            </select>
	               		</div>
               		</div>
               		
					<div class="col-md-3">
		                <div class="input-group">
		                	<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
		                    <input type="text" class="form-control number" maxlength="2" onkeydown="keyCode_codigo(event)"  id="codigo" name="codigo"  placeholder="N&uacute;mero" autocomplete="off">
	               		</div>
					</div>
					
					<div class="col-md-3">
		                <div class="input-group">
		                	<span class="input-group-addon">Bsf.</span>
		                    <input type="text" class="form-control" onkeydown="keyCode_monto(event)"  id="monto" name="monto"  placeholder="Ingrese Monto" autocomplete="off">
	               		</div>
					</div>
								
              		<div class="text-right">
						<a href="#" id="print" onclick="print()" class="btn btn-primary" {{ count($sale_cart) ? '' : 'disabled' }}>
                        	<i class="fa fa-print" aria-hidden="true"></i>
                        </a>
						<a data-target="#modal-delete" data-toggle="modal" href="#" id="trash" class="btn btn-danger" {{ count($sale_cart) ? '' : 'disabled' }}>
                        	<i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="btn btn-success" data-placement="bottom" data-target="#modal-pagar" data-toggle="modal">
                        	<i class="fa fa-money" aria-hidden="true"></i>
                        </a>
						<a href="#" class="btn btn-danger" data-placement="bottom" data-target="#modal-anular" data-toggle="modal">
                        	<i class="fa fa-ban" aria-hidden="true"></i>
                        </a>
                    </div>
                  </div>
                  <!-- END BTN Anular y Pagar -->	
                  
                </div>
                <!-- /.box-header -->
	                <div class="box-body ">
	                  	<div class="row">
	                  		<div class=" col-md-4 list">
					            <table class="table table-striped table-condensed text-center lotto-activo"> 
					            	@if($category == 1)
					            		@include('sales.categories.lottoactivo')
				                    @endif	
				                    
					            </table>
					        </div>
							<div class=" col-md-8">
								<div class="list-sale">
    					            <table class="table table-striped table-condensed text-center table-hover" id="tabla_product">
    					                <thead>
    					                    <tr>
    					                    	<th>Sorteo</th>
    					                        <th>N&uacute;mero: <span id="jugadas" style="color:#FF0000">{{ count($sale_cart) }}</span></th>
    					                        <th>Monto</th>
    					                        <th>Total:  <span id="total" style="color:#FF0000">{{ number_format($total,2,",",".") }}</span> </th>
    					                    </tr>
    					                </thead>
    					                <tbody id="add_product">
    					                	@if(count($sale_cart))
    						                	@foreach($sale_cart as $c)
    							                    <tr id="{{ $c->cod }}{{ substr($c->sorteo,0,2) }}">
    							                    	<td><h5>{{ $c->categorie }} {{ $c->hora }}</h5></td>
    							                        <td>
    						                                <h5>{{ $c->cod }} - {{ $c->name }}</h5>
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
<!--Modales -->
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
					<div class="shortcut-list-item">
						<h3 class="shortcut-list-item-header">Imprimir</h3>
						<div class="shortcut-list-item-keys">
							<span class="keyboard-key">M</span>
						</div>
						<div class="short-list-item-desc">
							<p>
								Si pulsa &laquo; esc &raquo;, se imprimir el ticket.
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
    <!-- Modalpara anular tickets -->		
	<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-anular">
		<form method="POST" action="{{ route('sale.anular', $category) }}">
           {{ csrf_field() }}
    		<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    	                     <i class="fa fa-times"></i>
    	                </button>
    	                <h4 class="modal-title">Anular Ticket</h4>
    				</div>
    				
    				<div class="modal-body">
        				<div class="form-group">
                          <label for="usr">Ingrese n&uacute;mero de ticket:</label>
                          <input type="text" class="form-control number" id="ticket" name="ticket" placeholder="N&uacute;mero" autocomplete="off">
                        </div>
                    </div>
                    
    				<div class="modal-footer">
    					<button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" id="btn-loading" data-loading-text="Cargando...">
							Confirmar
						</button>
    				</div>
    			</div>
    		</div>
    	</form>
	</div>
	<!-- Modal para pagar tickets -->		
	<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-pagar">
		<form method="POST" action="{{ route('sale.pagar', $category) }}">
           {{ csrf_field() }}
    		<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    	                     <i class="fa fa-times"></i>
    	                </button>
    	                <h4 class="modal-title">Pagar Ticket</h4>
    				</div>
    				
    				<div class="modal-body">
        				<div class="form-group">
                          <label for="usr">Ingrese n&uacute;mero de ticket:</label>
                          <input type="text" class="form-control number" id="ticket" name="ticket" placeholder="N&uacute;mero" autocomplete="off">
                        </div>
                    </div>
                    
    				<div class="modal-footer">
    					<button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" id="btn-loading" data-loading-text="Cargando...">
							Confirmar
						</button>
    				</div>
    			</div>
    		</div>
    	</form>
	</div>
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
					<a href="{{ route('sale.trash', $category) }}" id="btn-loading" data-loading-text="Cargando..." class="btn btn-primary">
                    	Confirmar
                    </a>
				</div>
				
			</div>
		</div>
	</div>
<!--Fin Contenido-->
@endsection
@push('scripts')
	<script>
        $('.number').on('input', function () { 
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
			    var categoria =  $('#categoria').val();
			    if(cod != '' && monto != ''){
				    //validamos si ha selecciondo sorteo
			    	if($('#sorteo').val() != null){
    					$('#codigo').val('');
        			    $('#codigo').focus(); 
        			    
        		    	 $.ajax({
    							url: appRoot + "/sale/add/" + cod ,
        		    	        type: "post",
        		    	        data: { "_token": "{{ csrf_token() }}", categoria: categoria, sorteo: sorteo, cod: cod, amount: monto  } ,
        		    	        success: function (data) {
//             		    	        console.log(data);
            		    	        //Validamos si esta abilitado o se excedio el limite
            		    	        if(data != 0 && data != 1) {
                		    	        if(data != 'error') {
                		    	        	data.forEach(function(data, index) {
//                 		    	        		console.log(data.categoria_hora);
                		    	        		var cod_ = cod + data.sorteo;
                			    	        	//SI EXISTE Y LO REPIREN LO REMUEVE 
                		    	        		$('#'+cod_).remove();
                		    	        		//END
                		    	        		
                    							add_ = '<tr id="'+cod_+'">';
                    							add_ += 	'<td>';
                								
                    							if(sorteo[index] == data.sorteo){ 
                    								add_ += '<h5>'+data.categoria_hora+'<h5>'; 
                        						} 
                        						
                        						add_ += 	'</td>';
                    							add_ += 	'<td><h5>';
                    							add_ += 		cod + ' - ' +data.name;
                    							add_ += 	'</h5></td>';
                    							add_ += 	'<td><h5>';
                    							add_ += 		data.monto;
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
                								total += parseInt($(this).find('td').eq(2).text()||0,10)
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
						total += parseInt($(this).find('td').eq(2).text()||0,10)
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
		                          