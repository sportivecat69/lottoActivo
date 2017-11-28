@extends('layouts.app-template')
@section('title', 'Agencias')
@section('content')
<?php 
$todaySold=App\Agency::todaySalesUser($seller->id);

$pendientes=App\Agency::todayPlays($agency->id,'PREMIADO', $seller->id)->plays;
$pagados=App\Agency::todayPlays($agency->id,'PAGADO', $seller->id)->plays;
$premiados=$pendientes+$pagados;

$premiadosSum=App\Agency::todayPrizes($agency->id, true);

$pendientes_=App\Agency::todayPrizes($agency->id, true, 'PREMIADO');
$pagados_=App\Agency::todayPrizes($agency->id, true, 'PAGADO');




$percentage=($todaySold*$agency->percentage_gain)/100;

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
    	<div class="row">
	    	<div class="col-md-6">
			      <!-- Default box -->
			      <div class="box box-warning">
			        <div class="box-header with-border">
			          <h3 class="box-title">Agencia: {{ $agency->name }}</h3>
			
			          <div class="box-tools pull-right">
			            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
			          </div>
			        </div>
			        <div class="box-body"> 
			              <table class="table no-margin">          
				                <tr><th>Descripci&oacute;n</th><td>{{ $agency->description }}</td></tr>
								<tr><th>Porcentaje de Ganancia</th><td>{{ number_format($agency->percentage_gain,2,",",".") }}</td></tr>
								<tr><th>N&uacute;mero de cajas</th><td>{{ $agency->num_cajas }}</td></tr>
								<tr><th>Minutos para Vender</th><td>{{ $agency->mint_sell }}</td></tr>
								<tr><th>Minutos para Cancelar</th><td>{{ $agency->mint_cancel }}</td></tr>
								<tr><th>Estatus</th><td>
									@if($agency->status === true)
										<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color:#68D332;"></i>
									@else
										<i class="fa fa-minus-circle fa-lg" aria-hidden="true" style="color:#FF0000;"></i>
									@endif
								</td></tr>
								
			              </table>
			        </div>
			        <!-- /.box-body -->
			        <div class="box-footer">
			          ...
			        </div>
			        <!-- /.box-footer-->
			      </div>
			      <!-- /.box -->
	      	</div> 
	     	<!-- /.col -->
	     	<div class="col-md-6">
	              <!-- DIRECT CHAT -->
	              <div class="box box-warning direct-chat direct-chat-warning">
	                <div class="box-header with-border">
	                  <h3 class="box-title">Loterias en Venta</h3>
	                  <div class="box-tools pull-right">
	                    <span data-toggle="tooltip" title="loterias" class="badge bg-yellow">{{ count($acs) }}</span>
	                  </div>
	                </div>
	                <!-- /.box-header -->
	                <div class="box-body">
	                	<div class="direct-chat-messages">
			                <div class="table-responsive">
			                <table class="table no-margin">
			                  <thead>
			                  <tr>
			                    <th>Item</th>
			                    <th>Apuesta M&iacute;nima</th>
			                    <th>Pago M&iacute;nimo</th>
			                    <th>Venta de Hoy</th>
			                  </tr>
			                  </thead>
			                  <tbody>
			                  	 @foreach($acs as $loteria)
				                  <tr>
				                    <td>{{ $loteria->categorie->name }}</td>
				                     <td>{{ number_format($loteria->bet_min,2,",",".")}}</td>
				                    <td>{{ number_format($loteria->prize_min,2,",",".")}}</td>
				                    <td>{{ number_format(App\Agency::todaySalesLottery($agency->id, $loteria->categorie->id, $seller->users_id),2,",",".")}}</td>
				                  </tr>
				                 @endforeach
			                  </tbody>
			                </table>
			              </div>
	              		  <!-- /.table-responsive -->
	              		</div>
	                </div>
	                <!-- /.box-body -->
	                <div class="box-footer">
	                  ...
	                </div>
	                <!-- /.box-footer-->
	              </div>
	              <!--/.direct-chat -->
	           </div>
	           <!-- /.col -->
	          </div> 
	           <!-- /.row -->
	           <div class="row">
		           <div class="col-md-3 col-sm-6 col-xs-12">
			          <div class="info-box">
			            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
			
			            <div class="info-box-content">
			              <span class="info-box-text">Venta de Hoy</span>
			              <span class="info-box-number"><?php echo number_format($todaySold,2,",","."); ?></span>
			            </div>
			            <!-- /.info-box-content -->
			          </div>
			          <!-- /.info-box -->
			        </div>
			        <!-- /.col -->
			        <div class="col-md-3 col-sm-6 col-xs-12">
			          <div class="info-box">
			            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>
			
			            <div class="info-box-content">
			              <span class="info-box-text">Ganancia</span>
			              <span class="info-box-number"><?php echo number_format(App\Agency::gainOfSeller($agency->id, $seller->id),2,",","."); ?></span>
			              <span><a href="{{ route('print.utility') }}" style="float: right;"><i class="fa fa-print"></i></a></span>
			            </div>
			            <!-- /.info-box-content -->
			          </div>
			          <!-- /.info-box -->
			        </div>
			        <!-- /.col -->
			        <div class="col-md-3 col-sm-6 col-xs-12">
			          <div class="info-box">
			            <span class="info-box-icon bg-yellow accent-2"><i class="fa fa-ticket"></i></span>
			
			            <div class="info-box-content">
			              <span class="info-box-text">Tickets Vendidos</span>
			              <span class="info-box-number"><?php echo App\Agency::todayTickets($agency->id, null, $seller->id); ?></span>
			            </div>
			            <!-- /.info-box-content -->
			          </div>
			          <!-- /.info-box -->
			        </div>
			        <!-- /.col -->
			        <div class="col-md-3 col-sm-6 col-xs-12">
			          <div class="info-box">
			            <span class="info-box-icon bg-red accent-2"><i class="fa fa-ticket"></i></span>
			
			            <div class="info-box-content">
			              <span class="info-box-text">Tickets Anulados</span>
			              <span class="info-box-number"><?php echo App\Agency::todayTickets($agency->id, 'ANULADO', $seller->id); ?></span>
			            </div>
			            <!-- /.info-box-content -->
			          </div>
			          <!-- /.info-box -->
			        </div>
			        <!-- /.col -->
		        </div>
		        <!-- /.row -->
		        <div class="row">
			        <div class="col-md-3 col-sm-6 col-xs-12">
			          <div class="info-box">
			            <span class="info-box-icon bg-purple"><i class="fa fa-shopping-cart"></i></span>
			
			            <div class="info-box-content">
			              <span class="info-box-text">Total Jugadas</span><?php $jugadas=App\Agency::todayPlays($agency->id, null, $seller->id);?>
			              <span class="info-box-number"><?php echo $jugadas->plays; ?></span>
			            </div>
			            <!-- /.info-box-content -->
			          </div>
			          <!-- /.info-box -->
			        </div>
			        <!-- /.col -->
			        
			        <div class="col-md-3 col-sm-6 col-xs-12">
				        <div class="info-box bg-blue">
				            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
				
				            <div class="info-box-content">
				              <span class="info-box-text">Jugadas Premiadas</span>
				              <span class="info-box-number"><?php echo  $premiados; ?></span>
				
				              <div class="progress">
				                <div class="progress-bar" style="width: 50%"></div>
				              </div>
				              <span class="progress-description">
				                    {{ number_format($premiadosSum,2,",",".") }}
				                  </span>
				            </div>
				            <!-- /.info-box-content -->
				          </div> 
			         </div>
			          <!-- /.col -->
			        <div class="col-md-3 col-sm-6 col-xs-12">
				        <div class="info-box bg-red">
				            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
				
				            <div class="info-box-content">
				              <span class="info-box-text">Pagos Pendientes</span>
				              <span class="info-box-number"><?php echo  $pendientes; ?></span>
				
				              <div class="progress">
				                <div class="progress-bar" style="width: 50%"></div>
				              </div>
				              <span class="progress-description">
				                    {{ number_format($pendientes_,2,",",".") }}
				                  </span>
				            </div>
				            <!-- /.info-box-content -->
				          </div> 
			         </div>
			          <!-- /.col -->
			        <div class="col-md-3 col-sm-6 col-xs-12">
				        <div class="info-box bg-orange">
				            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
				
				            <div class="info-box-content">
				              <span class="info-box-text">Pagos Realizados</span>
				              <span class="info-box-number"><?php echo  $pagados; ?></span>
				
				              <div class="progress">
				                <div class="progress-bar" style="width: 50%"></div>
				              </div>
				              <span class="progress-description">
				                    {{ number_format($pagados_,2,",",".")  }}
				                  </span>
				            </div>
				            <!-- /.info-box-content -->
				          </div> 
			         </div>
			          <!-- /.col -->
			      </div>
			      <!-- /.row -->
			      
			      <!-- =========================================================== -->
    @foreach($acs as $loteria)
      <?php 
			$bestSeller=App\Agency::bestSeller($agency->id, $loteria->categorie->id, 5, $seller->id); // los 5 mas vendidos
	  ?>
      <div class="row">
      	<div class="col-md-12 col-sm-12 col-xs-12">
	      <div class="box box-warning">
	            <div class="box-header with-border">
	              <h3 class="box-title">Ranking m&aacute;s vendidos {{ $loteria->categorie->name }}</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>Cod</th>
	                    <th>Nombre</th>
	                    <th>Jugadas</th>
	                    <th>Ventas</th>
	                  </tr>
	                  </thead>
	                  <tbody>
	                  <?php if(count($bestSeller)>0) : ?>
		                  @foreach($bestSeller as $bS)
		                  <tr>
		                    <td><a href="#">{{ $bS->articles_id }}</a></td>
		                    <td>{{$bS->name_article}}</td>
		                    <td><span class="label label-success">{{ $bS->plays }}</span></td>
		                    <td>{{ number_format($bS->ventas,2,",",".") }}</td>
		                  </tr>
		                  @endforeach
	                  <?php else :?>
	                  	<tr><td colspan="4">No hay jugadas</td></tr>
	                 <?php endif;?>
	                  </tbody>
	                </table>
	              </div>
	              <!-- /.table-responsive -->
	            </div>
	            <!-- /.box-body -->
	            
	        </div>
     	 </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
	@endforeach
       <!-- =========================================================== --> 
		        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--Fin Contenido-->
@endsection