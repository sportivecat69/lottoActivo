<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SellerAgency;
use App\Agency;
use App\AgencyCategoriesSell;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Carbon\Carbon;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }
    
    /**
     * Display the specified resource agency por specified user seller
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indexSeller()
    {
    	// obtener datod del usuario autenticado
    	
    	if(Auth::user()->hasRole('seller')){
    		
    		$seller=SellerAgency::where('users_id',Auth::user()->id)->first();
    		$agency=Agency::where('id', $seller->agencies_id)->first();
    		$acs = AgencyCategoriesSell::where('agencies_id',$agency->id)->get();

    		return view('dashboard.index-seller',['seller' => $seller, 'agency' => $agency, 'acs'=>$acs]);
    		
    	}else{
    		
    		return redirect()->route('dashboard')->with('fail', 'Usted no puede obtener la petici&oacute;n realizada');
    		
    	}
    }
    
    public function getChartSold(){
    	return view('dashboard.chart-sold');
    }
    
    
    public function printUtilidad($agency_id=null)
    {
    	
    	//Auth::user()->id

    	$nombre_impresora = "POS-58-Series";
    	 
    	 
    	$connector = new WindowsPrintConnector($nombre_impresora);
    	$printer = new Printer($connector);
    	 
    	# Vamos a alinear al centro lo próximo que imprimamos
    	$printer->setJustification(Printer::JUSTIFY_LEFT);
    	 
    	/*
    	Ahora vamos a imprimir un encabezado
    	 */
    	//Consulto el nombre de la agencia mediante el usuario
    	$seller_agency = SellerAgency::where('users_id', Auth::user()->id)->first();
	  
    	$printer->text($seller_agency->agency->name . "\n");
    	#La fecha también
    	$printer->text("Fecha: ".date("d/m/Y") ." Hora: ".date("h:i:s") . "\n");
    	#Motivo de impresi�n
    	$printer->text("Resumen de Utilidad para Hoy \n");
    	#usuario
    	$printer->text(Auth::user()->firstname." ".Auth::user()->lastname);
    	
    	if(Auth::user()->hasRole('seller')){
    		    		
    		#total de ventas
    		$todaySold=Agency::todaySalesUser($seller_agency->id);
    		$ganancia=Agency::gainOfSeller($seller_agency->agency->id,$seller_agency->id);
    		$premios=Agency::todayPrizes($seller_agency->agency->id, true);
    		
    		$printer->text("Total de Ventas: " .number_format($todaySold,2,",","."). " Bs. \n");
    		
    		#porcentaje de ganancias
    		$printer->text("- Porcentaje: " .number_format($seller_agency->agency->percentage_gain,2,",","."). "%  \n");
    		$printer->text("- Ganancia: " .number_format($ganancia,2,",","."). "Bs.  \n");
    		
    		#premios
    		$printer->text("- Premios: " .number_format($premios,2,",","."). "Bs.  \n");
    		
    		#utilidad
    		$utilidad=$todaySold-$ganancia-$premios;
    		$printer->text("\n Utilidad: " .number_format($utilidad,2,",","."). " Bs. \n");

    	}elseif(Auth::user()->hasRole('banker')){
    		
    		if(is_int($agency_id)){
    			
	    		$Agencia= Agency::find($agency_id);
	    		try {
		    			#total de ventas
		    			$todaySold=Agency::todaySales($Agencia->id);
		    			$ganancia=Agency::gainOfBanker($Agencia->id);
		    			$premios=Agency::todayPrizes($Agencia->id, true);
		    			
		    			$printer->text("Total de Ventas: " .number_format($todaySold,2,",","."). " Bs. \n");
		    			
		    			#porcentaje de ganancias
		    			$printer->text("- Porcentaje: " .number_format($Agencia->percentage_gain,2,",","."). "%  \n");
		    			$printer->text("- Ganancia: " .number_format($ganancia,2,",","."). "Bs.  \n");
		    			
		    			#premios
		    			$printer->text("- Premios: " .number_format($premios,2,",","."). "Bs.  \n");
		    			
		    			#utilidad
		    			$utilidad=$todaySold-$ganancia-$premios;
		    			$printer->text("\n Utilidad: " .number_format($utilidad,2,",","."). " Bs. \n");
		    			
				} catch (Exception $e) {//verificar
				    $printer->text("-Error- No se ha conseguido la agencia. \n");
				}

    		}else{
    			$printer->text("-Error- No se ha conseguido la agencia. \n");
    		}
    		
    	}
    	
    	 
    	/*
    	Podemos poner también un pie de página
    	*/
    				$printer->text("---TodoLotto---");
    	    				 
    	    		/*Alimentamos el papel 3 veces*/
    	    		$printer->feed(3);
    	    		 
    	    		/*
    	    		Cortamos el papel. Si nuestra impresora
    	    		no tiene soporte para ello, no generará
	     ningún error
    	    		*/
    	    		$printer->cut();
    	    		 
    	    		/*
    	    		Por medio de la impresora mandamos un pulso.
    	    		Esto es útil cuando la tenemos conectada
    	    		por ejemplo a un cajón
    	    		 */
    	    		$printer->pulse();
    	    		 
    	    		/*
    	    		Para imprimir realmente, tenemos que "cerrar"
    	    		la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
    	    		*/
    	    		$printer->close();
    	    		 
	}
	
	
}
