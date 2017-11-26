@extends('layouts.app-template')
@section('title', 'Agencias')
@section('content')
<?php 
$todaySold=App\Agency::todaySales($agency->id);

$pendientes=App\Agency::todayPlays($agency->id,'PREMIADO')->plays;
$pagados=App\Agency::todayPlays($agency->id,'PAGADO')->plays;
$premiados=$pendientes+$pagados;

$premiadosSum=App\Agency::todayPrizes($agency->id, true);

$pendientes_=App\Agency::todayPrizes($agency->id, true, 'PREMIADO');
$pagados_=App\Agency::todayPrizes($agency->id, true, 'PAGADO');




$percentage=($todaySold*$agency->percentage_gain)/100;
$utilidad=$todaySold-$percentage-$premiadosSum;

$string = ($utilidad>0) ? '<i class="fa fa-thumbs-up" aria-hidden="true"></i>   &iexcl;Felicidades! tienes una utilidad de ' : '<i class="fa fa-thumbs-down" aria-hidden="true"></i>   &iexcl;Vaya! parece que tienes perdidas por '
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     <div class="row"  style="padding: 20px 30px; background: rgb(243, 156, 18); font-size: 16px; font-weight: 600;">
      <div><span style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;">Aqu&iacute; podr&aacute;s ver el detalle de la actividad de tu agencia el d&iacute;a de Hoy... </span><span class="pull-right" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;"><?php echo $string; ?> <span class="btn btn-default btn-sm" style="margin-left: 10px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">{{ number_format($utilidad,2,",",".") }} Bs.</span></span></div>
   </div>
   <!-- /.row  -->
    
    <!-- Main content -->
    <section class="content">
     <div class="row">
      <div class="col-md-4">
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
      <!-- =========================================================== -->
      
     
            <div class="col-md-4">
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
			                    <td>{{ number_format(App\Agency::todaySalesLottery($agency->id, $loteria->categorie->id),2,",",".")}}</td>
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

	 		<div class="col-md-4">
	 			<div class="direct-chat-messages" style="height: 325px; margin-bottom: 20px">
                  <p class="text-center">
                    <strong>Ventas por Taquilla</strong>
                  </p>
				  
				  <?php $colors=array('progress-bar-aqua','progress-bar-red','progress-bar-green','progress-bar-yellow'); $i=0;?>
				  @if(!count($sellers)==0)
	                  @foreach($sellers as $seller)
	                  		
		                  <div class="progress-group"><?php $soldUser=App\Agency::todaySalesUser($seller->id); $porc=($todaySold>0) ? (($soldUser*100)/$todaySold) : 0; ?>
		                    <span class="progress-text">{{$seller->user->firstname}}  {{$seller->user->lastname}} </span>
		                    <span class="progress-number"><b><?php echo number_format($soldUser,2,",",".");?></b>/{{ number_format($porc,2,",",".")}}%</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar {{$colors[$i]}}" style="width: {{$porc}}%"></div>
		                    </div>
		                  </div>
		                   <?php $i= ($i<4) ? $i+1 : 0;?>
		                  <!-- /.progress-group -->
	                  @endforeach
                  @else
                  	<div class="alert alert-warning show" role="alert"><span>No hay vendedores activos</span></div>
                  @endif
                  	 
                  </div>
                </div>
				<!-- /.col -->
				
          </div> <!-- /.row -->

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
              <span class="info-box-number"><?php echo number_format(App\Agency::gainOfBanker($agency->id),2,",","."); ?></span>
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
              <span class="info-box-number"><?php echo App\Agency::todayTickets($agency->id); ?></span>
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
              <span class="info-box-number"><?php echo App\Agency::todayTickets($agency->id, 'ANULADO'); ?></span>
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
              <span class="info-box-text">Total Jugadas</span><?php $jugadas=App\Agency::todayPlays($agency->id);?>
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
			$bestSeller=App\Agency::bestSeller($agency->id, $loteria->categorie->id, 5); // los 5 mas vendidos
	  ?>
      <div class="row">
      	<div class="col-md-12 col-sm-12 col-xs-12">
	      <div class="box box-info">
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