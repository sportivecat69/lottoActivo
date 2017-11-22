@extends('layouts.app-template')
@section('title', 'Agencias')
@section('content')
<?php $todaySold=App\Agency::todaySales($agency->id);
App\Agency::bestSeller($agency->id, 1);
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
      <!--  -->
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
        <?php $pendientes=App\Agency::todayPlays($agency->id,'PREMIADO');?>
        <?php $pagados=App\Agency::todayPlays($agency->id,'PAGADO'); ?>
        <?php $premiados=$pendientes->plays+$pagados->plays;?>
        <?php $premiadosSum=$pendientes->ventas+$pagados->ventas;?>
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
	              <span class="info-box-number"><?php echo  $pendientes->plays; ?></span>
	
	              <div class="progress">
	                <div class="progress-bar" style="width: 50%"></div>
	              </div>
	              <span class="progress-description">
	                    {{ number_format($pendientes->ventas,2,",",".") }}
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
	              <span class="info-box-number"><?php echo  $pagados->plays; ?></span>
	
	              <div class="progress">
	                <div class="progress-bar" style="width: 50%"></div>
	              </div>
	              <span class="progress-description">
	                    {{ number_format($pagados->ventas,2,",",".")  }}
	                  </span>
	            </div>
	            <!-- /.info-box-content -->
	          </div> 
         </div>
          <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- =========================================================== -->
      <div class="row">
      	<div class="col-md-12 col-sm-12 col-xs-12">
	      <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Latest Orders</h3>
	
	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>Order ID</th>
	                    <th>Item</th>
	                    <th>Status</th>
	                    <th>Popularity</th>
	                  </tr>
	                  </thead>
	                  <tbody>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
	                    <td>Call of Duty IV</td>
	                    <td><span class="label label-success">Shipped</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
	                    <td>Samsung Smart TV</td>
	                    <td><span class="label label-warning">Pending</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
	                    <td>iPhone 6 Plus</td>
	                    <td><span class="label label-danger">Delivered</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
	                    <td>Samsung Smart TV</td>
	                    <td><span class="label label-info">Processing</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
	                    <td>Samsung Smart TV</td>
	                    <td><span class="label label-warning">Pending</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
	                    <td>iPhone 6 Plus</td>
	                    <td><span class="label label-danger">Delivered</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
	                    <td>Call of Duty IV</td>
	                    <td><span class="label label-success">Shipped</span></td>
	                    <td>
	                      <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
	                    </td>
	                  </tr>
	                  </tbody>
	                </table>
	              </div>
	              <!-- /.table-responsive -->
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer clearfix">
	              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
	              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
	            </div>
	            <!-- /.box-footer -->
	          </div>
     	 </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
       <!-- =========================================================== -->
      
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--Fin Contenido-->
@endsection