@extends('layouts.app-template')
@section('title', 'Agencias')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
     <div class="row">
      <div class="col-md-8">
		      <!-- Default box -->
		      <div class="box box-warning">
		        <div class="box-header with-border">
		          <h3 class="box-title">Agencia: {{ $agency->name }}</h3>
		
		          <div class="box-tools pull-right">
		            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
		              <i class="fa fa-minus"></i></button>
		          </div>
		        </div>
		        <div class="box-body"> 
		              <table class="table table-bordered">          
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
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
          </div> <!-- /.row -->
      <!--  -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Venta de Hoy</span>
              <span class="info-box-number"><?php echo number_format(App\Agency::todaySales($agency->id),2,",","."); ?></span>
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
            <span class="info-box-icon bg-yellow"><i class="fa fa-ticket"></i></span>

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
            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tickets Premiados</span>
              <span class="info-box-number"><?php echo App\Agency::todayTickets($agency->id,'PREMIADO'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- =========================================================== -->
      
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">Add Products to Cart</span>
                    <span class="progress-number"><b>160</b>/200</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Complete Purchase</span>
                    <span class="progress-number"><b>310</b>/400</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="progress-number"><b>480</b>/800</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Send Inquiries</span>
                    <span class="progress-number"><b>250</b>/500</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL REVENUE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">TOTAL COST</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                    <h5 class="description-header">$24,813.53</h5>
                    <span class="description-text">TOTAL PROFIT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">GOAL COMPLETIONS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
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