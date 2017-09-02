@extends('layouts.app-template')
@section('title', 'Gestor de Venta')
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
                  <h3 class="box-title">Factura</h3>
                </div>
                <!-- /.box-header -->
	                <div class="box-body">
	                  	<div class="row">
							<div class="box-body">
			                  	<div class="row">
									<div class="col-sm-12 col-md-8">
							            <table class="table table-striped table-condensed table-hover text-center">
							                <thead>
							                    <tr>
							                    	<th>Codigo</th>
							                        <th>Producto</th>
							                        <th>Cantidad</th>
							                        <th>Precio Comp.</th>
							                        <th>Sub-Total</th>
							                    </tr>
							                </thead>
							                <tbody>
							                	@foreach($details as $c)
								                    <tr>
								                    	<td><h5>{{ $c->cod }}</h5></td>
								                        <td>
							                                <h5>{{ $c->product }}</h5>
								                        </td>
								                        <td>
							                                <h5>{{ $c->quantity }}</h5>
								                        </td>
								                        <td>
							                                <h5>Bs. {{ number_format($c->price,2,",",".") }} Bsf.</h5>
								                        </td>
								                        <td><h5>{{ number_format($c->quantity * $c->price,2,",",".") }} Bsf.</h5></td>
								                    </tr>
								                @endforeach
							                </tbody>
							            </table>
							           </div>
							           
							           <div class="col-sm-12 col-md-4">
							            <table class="table table-striped table-condensed"> 
						                    <tr>
						                        <td colspan="2">
						                        	<h4 class="text-center">Detalles del pedido</h4>
						                        </td>
						                    </tr>
						                    <tr>
							                    @php
										            //Agregamos 4 posiciones
										            function formato($c) {
										              printf("%04d<br>", $c);
										            }
							                    @endphp
						                        <td><h5><strong>N&uacute;mero de Factura<strong></h5></td>
						                        <td class="text-right">
						                        	<h5>
						                        		<strong>
						                        			<span style="color: red;">{{ formato($num_factura) }}</span>
						                        		</strong>
						                        	</h5>
						                        </td>
						                    </tr>
						                    <tr>
						                    	<td><h5>Cliente</h5></td>
						                        <td class="text-right">
						                        	<h5>
						                        		<strong>{{ $sale_invoice->client }}</strong>
						                        	</h5>
						                        </td>
						                    </tr>
						                    <tr>
						                    	<td><h5>Rif/Cedula</h5></td>
						                        <td class="text-right">
						                        	<h5>
						                        		<strong>{{ $sale_invoice->doc }}</strong>
						                        	</h5>
						                        </td>
						                    </tr>
						                    <tr>
						                        <td><h5>Subtotal</h5></td>
						                        <td class="text-right"><h5><strong>{{ number_format($sub_total,2,",",".") }} Bsf.</strong></h5></td>
						                    </tr>
						                    <tr>
						                        <td><h5>IVA 12%</h5></td>
						                        <td class="text-right"><h5><strong>{{ number_format($sub_total*12/100,2,",",".") }} Bsf.</strong></h5></td>
						                    </tr>
						                    <tr>
						                        <td><h5>Total</h5></td>
						                        <td class="text-right" style="color:#028100;">
						                        	<h5><strong>{{ number_format($sub_total+($sub_total*12/100),2,",",".") }} Bsf.</strong></h5>
						                        </td>
						                    </tr>
						                    <tr>
						                        <td><h5>Importe</h5></td>
						                        <td class="text-right"><h5><strong>{{ number_format($sale_invoice->amount_received,2,",",".") }} Bsf.</strong></h5></td>
						                    </tr>
						                    <tr>
						                        <td><h4>Cambio</h4></td>
						                        <td class="text-right" style="color:#FF0000;">
						                        	<h4><strong>{{ number_format($sale_invoice->amount_received-($sub_total+($sub_total*12/100)),2,",",".") }} Bsf.</strong></h4>
						                        </td>
						                    </tr>
						                    <tr>
						                        <td>
							                        <a href="{{ URL::previous() }}" class="btn btn-success col-sm-12 col-md-12">
							                        	Regresar
							                        </a>
							                     </td>
							                     <td>
							                    	<a href="#" onclick="popitup('{{ route('sale.invoicePdf', $num_factura) }}')" title="Imprimir" class="btn btn-primary col-sm-12 col-md-12">
							                        	<i class="fa fa-print" aria-hidden="true"></i>
							                        </a>
							                     </td>
					                        </tr>
							            </table>
							        </div>
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
		function popitup(url)
		{
		  newwindow=window.open(url,'name','height=570,width=730');
		  if (window.focus) {newwindow.focus()}
//			Imprime automatico toda la pantalla
// 	    	window.print();
		  return false;
		}
	</script>
@endpush
		  		                   