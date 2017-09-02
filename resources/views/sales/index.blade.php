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
		  width: 90px;
		}
		
		/** ESTILOS DE SCROLL **/
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
	</style>
@endpush
@section('content')

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
        
        @if (session('status'))
            <div class="alert alert-danger alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>
			  {{ session('status') }}
			</div>
         @endif
        
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
											<span class="keyboard-key">A</span>
										</div>
										<div class="shortcut-list-item-keys">
											<span class="keyboard-key">ENTER</span>
										</div>
										<div class="short-list-item-desc">
											<p>
												Si pulsa &laquo;enter&raquo; o &laquo;a&raquo;, se a&ntilde;adira el articulo buscado a 
												la lista de compra siempre y cuando estes parado sobre el monto.
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
												Si pulsa &laquo;c&raquo;, se fijara el foco en el input del codigo.
											</p>
										</div>
									</div>
									<div class="shortcut-list-item">
										<h3 class="shortcut-list-item-header">Fijar foco en la monto</h3>
										<div class="shortcut-list-item-keys">
											<span class="keyboard-key">Q</span>
										</div>
										<div class="short-list-item-desc">
											<p>
												Si pulsa &laquo;m&raquo;, se fijara el foco en el input de monto.
											</p>
										</div>
									</div>
									<div class="shortcut-list-item">
										<h3 class="shortcut-list-item-header">Borrar la informaci&oacute;n de la busqueda</h3>
										<div class="shortcut-list-item-keys">
											<span class="keyboard-key">R</span>
										</div>
										<div class="short-list-item-desc">
											<p>
												Si pulsa &laquo;r&raquo;, se borrara la informaci&oacute;n buscada.
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
				                        	<h4 class="text-center">Lista de Animalitos</h4>
				                        </td>
				                    </tr>
				                    <tr>
				                        <td colspan="3">
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
				                    </tr>
				                    <tr>
				                  		<td>
				                  			<a href="#" onclick="add('04')">
				                  				<img alt="04" src="{{asset('img/animalitos/04.png')}}">
				                  			</a>
				                  		</td>
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
				                    </tr>
				                    <tr>
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
				                        <td>
				                        	<a href="#" onclick="add('09')">
				                       			<img alt="09" src="{{asset('img/animalitos/09.png')}}">
				                       		</a>
				                       	</td>
				                    </tr>
				                    <tr>
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
				                    </tr>
				                   <tr>
				                        <td>
				                        	<a href="#" onclick="add('16')">
				                        		<img alt="16" src="{{asset('img/animalitos/16.png')}}">
				                        	</a>
				                        </td>
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
				                    </tr>
				                   <tr>
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
				                        <td>
				                        	<a href="#" onclick="add('21')">
				                        		<img alt="21" src="{{asset('img/animalitos/21.png')}}">
				                        	</a>
				                        </td>
				                    </tr>
				                   <tr>
				                   		<td><img alt="22" src="{{asset('img/animalitos/22.png')}}"></td>
				                    	<td><img alt="23" src="{{asset('img/animalitos/23.png')}}"></td>
				                        <td><img alt="24" src="{{asset('img/animalitos/24.png')}}"></td>
				                    </tr>
				                   <tr>
				                   		<td><img alt="25" src="{{asset('img/animalitos/25.png')}}"></td>
				                    	<td><img alt="26" src="{{asset('img/animalitos/26.png')}}"></td>
				                        <td><img alt="27" src="{{asset('img/animalitos/27.png')}}"></td>
				                    </tr>
				                   <tr>
				                   		<td><img alt="28" src="{{asset('img/animalitos/28.png')}}"></td>
				                    	<td><img alt="29" src="{{asset('img/animalitos/29.png')}}"></td>
				                        <td><img alt="30" src="{{asset('img/animalitos/30.png')}}"></td>
				                    </tr>
				                   <tr>
				                   		<td><img alt="31" src="{{asset('img/animalitos/31.png')}}"></td>
				                    	<td><img alt="32" src="{{asset('img/animalitos/32.png')}}"></td>
				                        <td><img alt="33" src="{{asset('img/animalitos/33.png')}}"></td>
				                    </tr>
				                   <tr>
				                   		<td><img alt="34" src="{{asset('img/animalitos/34.png')}}"></td>
				                    	<td><img alt="35" src="{{asset('img/animalitos/35.png')}}"></td>
				                        <td><img alt="36" src="{{asset('img/animalitos/36.png')}}"></td>
				                    </tr>
					            </table>
					        </div>
    							<div class=" col-md-8">
    								<div class=" col-md-12">
    									<div class="col-md-4">
    						                <div class="input-group">
    						                	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    						                    <select id="sorteo" name="sorteo[]" class="selectpicker show-menu-arrow form-control" multiple data-actions-box="true" title="Seleccione Sorteo" data-selected-text-format="count > 2">
                                                  <option value="10:00 am">10:00 am</option>
                                                  <option value="11:00 am">11:00 am</option>
                                                  <option value="12:00 am">12:00 am</option>
                                                  <option value="01:00 pm">01:00 pm</option>
                                                  <option value="04:00 pm">04:00 pm</option>
                                                  <option value="05:00 pm">05:00 pm</option>
                                                  <option value="06:00 pm">06:00 pm</option>
                                                  <option value="07:00 pm">07:00 pm</option>
                                                </select>
    					               		</div>
					               		</div>
        								<div class="col-md-4">
    						                <div class="input-group">
    						                	<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
    						                    <input type="text" class="form-control" maxlength="2" onkeydown="keyCode_codigo(event)"  id="codigo" name="codigo"  placeholder="Ingrese codigo" >
    					               		</div>
        								</div>
        								<div class="col-md-4" style=" display: inline-flex;">
    						                <div class="input-group col-md-10">
    						                	<span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
    						                    <input type="text" class="form-control money" onkeydown="keyCode_monto(event)"  id="monto" name="monto"  placeholder="Ingrese Monto" >
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
					            <table class="table table-striped table-condensed table-hover text-center" id="tabla_product">
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
						                                <h5>{{ number_format($c->amount,2,",",".") }}</h5>
							                        </td>
							                        <td>
								                        <a href="#" onclick="delete_('{{ $c->cod }}{{ substr($c->sorteo,0,2)}}')">
								                        	<h5><i class="fa fa-times fa-lg" aria-hidden="true" style="color:#FF0000;"></i></h5>
								                        </a>
							                        </td>
							                    </tr>
							                @endforeach
							                </tr>
							             @else
							             	<tr id="no_product">
							             		<td colspan="7"><b>No hay productos agregados</b></td>
							             	</tr>
							             @endif
					                </tbody>
					            </table>
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
		    $('#monto').focus();
		    return false;
		}

		//Boton loading...
		$("#btn-loading-confirmar").click(function() {
		    var $btn = $(this);
		    $btn.button('loading');
		//	    // simulating a timeout
		//	    setTimeout(function () {
		//	        $btn.button('reset');
		//	    }, 1000);
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
		    if (x == 82) { // 82 = r => borra la busqueda
		    	window.location.href = '{{ route('sale.index') }}';
		    }
		}
		
		//funciones con teclado desde monto
		function keyCode_monto(event) {
		    var x = event.keyCode;
		    if (x == 13) { // 13 = enter => agregar al carrito
		    	 $.ajax({
		    	        url: "{{ route('sale.add',  '0' ) }}",
		    	        type: "post",
		    	        data: { "_token": "{{ csrf_token() }}", categorie: 1, sorteo: $('#sorteo').val(), cod: $('#codigo').val(), amount: $('#monto').val()  } ,
		    	        success: function (data) {
		    	        	$.each(data, function(index){
			    	        	
			    	        	//SI EXISTE Y LO REPIREN LO REMUEVE 
		    	        		$('#'+data[index].cod+data[index].sorteo.substring(0, 2)).remove();
		    	        		//END
		    	        		
    							add = '<tr id="'+data[index].cod+data[index].sorteo.substring(0, 2)+'">';
    							add += 	'<td>';
    							if(data[index].categorie_id == 1){ 
    								add += '<h5>Ruleta Activa<h5>'; 
        						};
    							add += 	'</td>';
    							add += 	'<td><h5>';
    							add += 		data[index].cod + '-' +data[index].name;
    							add += 	'</h5></td>';
    							add += 	'<td><h5>';
    							add += 		data[index].sorteo;
    							add += 	'</h5></td>';
    							add += 	'<td><h5>';
    							add += 		data[index].amount + ',00 ';
    							add += 	'</h5></td>';
    							add +=   '<td>';
    							add +=    	'<a href="#" onclick="delete_(\''+data[index].cod+data[index].sorteo.substring(0, 2)+'\')">';
    							add +=    		'<h5><i class="fa fa-times fa-lg" aria-hidden="true" style="color:#FF0000;"></i></h5>';
    							add +=    	'</a>';
    							add +=	'</td>'
    							add += '</tr>';
    							$('#no_product').html('');
    							$('#add_product').append(add);
		    	        	});

		    	        	//Calcula el monto
							var total = 0;
							$('#tabla_product tbody tr').each(function(){
								total += parseInt($(this).find('td').eq(3).text()||0,10)
							});
							$('#total').html(total+',00');
							//Calculo de Nro. jugadas
							$('#jugadas').html($('#tabla_product tbody tr').size());
							
							$('#codigo').val('');
		    			    $('#codigo').focus();               

		    	        },
		    	        error: function(jqXHR, textStatus, errorThrown) {
		    	           console.log(textStatus, errorThrown);
		    	        }
		    	    });
		    	    
		    	 return false;
		    }
		    if (x == 65) { // 65 = a => agregar al carrito
				if($('#quantity').val() > $('#stok').val()) {
					alert('no tiene suficientes productos para ese pedido');
				} else {
			    	event.preventDefault();
			        document.getElementById('add-product').submit();
				}
		    }
		    if (x == 67) { // 67 = c => focus en el codigo
		    	document.getElementById("codigo").focus();
		    }
		    if (x == 82) { // 82 = r => borra la busqueda
		    	window.location.href = '{{ route('sale.index') }}';
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
	    	        },
	    	        error: function(jqXHR, textStatus, errorThrown) {
	    	           console.log(textStatus, errorThrown);
	    	        }
	    	    });
	    }
	
	</script>
@endpush
		                          