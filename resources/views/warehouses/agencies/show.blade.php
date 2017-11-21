@extends('layouts.app-template')
@section('title', 'Agencias')
@section('content')
<?php $todaySold=App\Agency::todaySales($agency->id);
App\Agency::todayPlays($agency->id);

App\Agency::todaySalesLottery($agency->id, 2);

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
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
		                  </tr>
		                  </thead>
		                  <tbody>
		                  	 @foreach($acs as $loteria)
			                  <tr>
			                    <td>{{ $loteria->categorie->name }}</td>
			                     <td>{{ number_format($loteria->bet_min,2,",",".")}}</td>
			                    <td>{{ number_format($loteria->prize_min,2,",",".")}}</td>
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
      <!--  -->
      <div class="row">
        <div class="col-md-2 col-sm-4 col-xs-12">
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
        <div class="col-md-2 col-sm-4 col-xs-12">
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
        <div class="col-md-2 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow accent-2"><i class="fa fa-ticket"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tickets</span>
              <span class="info-box-number"><?php echo App\Agency::todayTickets($agency->id); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Jugadas</span>
              <span class="info-box-number"><?php echo App\Agency::todayPlays($agency->id); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Premios</span>
              <span class="info-box-number"><?php echo App\Agency::todayPlays($agency->id,'PREMIADO'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
		<div class="col-md-2 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-arrow-down"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pagos</span>
              <span class="info-box-number"><?php echo App\Agency::todayPlays($agency->id,'PAGADO'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- =========================================================== -->
      
       <!-- =========================================================== -->
      
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--Fin Contenido-->
@endsection