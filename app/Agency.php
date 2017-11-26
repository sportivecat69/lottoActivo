<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agency extends Model
{
	/**
	 * Rules for model
	 *
	 */
	
	public   $rules = [
		'name' => 'required|min:3|max:35',
		'description' => 'required|min:3|max:35',
		'percentage_gain' => 'required|numeric|between:0,100',
		'num_cajas' => 'required|integer',
		'mint_sell' => 'required|integer|between:0,60',
		'mint_cancel' => 'required|integer|between:0,60',
	];
	
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'description', 'percentage_gain', 'num_cajas', 'mint_sell', 'mint_cancel'
	];
	
	public function insert($data){
		
		$agency = new self();
		
		foreach ($data as $key=>$value){
				$agency->setAttribute($key, $value);
		}

		$val=$agency->save();
		if($val){
			return $agency->id;
		}else{
			return false;
		}
 		
		
	}
	
	
	public function edit($data, $id){
	
		$agency = self::find($id);

		foreach ($data as $key=>$value){
			$agency->setAttribute($key, $value);
		}
	
		$val=$agency->save();
		if($val){
			return $agency->id;
		}else{
			return false;
		}
	
	}
	
	/**
	 * Sellers for specified agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function sellersAgency($id){

		$sellers=SellerAgency::where('agencies_id', $id)->get();
		return $sellers;
	}
	
	
	/**
	 * today's sales for specified agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function todaySales($id){

		$total=0;
		$sellers=self::sellersAgency($id); // se recorre por usuario asociado a la agencia
		$array_sellers=array();
		
		foreach ($sellers as $seller){ // ventas por usuarios asociados a la agencia
			$array_sellers[]=$seller->id;
		}
		
		$ventas = \DB::table('sale_invoices')
			->select(\DB::raw("SUM(total) as ventas"))
			->where('created_at','>=', Carbon::today())
			->where('created_at','<=', Carbon::today()->addDay(1))
			->where('status','<>', 'ANULADO') // NO SE CONSIDERAN LOS ANULADOS
			->whereIn('sellers_agency_id', $array_sellers)
			->get();
				
		$total=$ventas[0]->ventas;

		return $total;
		
	}
	
	
	/**
	 * today's sales for specified user agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function todaySalesUser($id){ // sellers_agency_id

		$ventas = \DB::table('sale_invoices')
			->select(\DB::raw("SUM(total) as ventas"))
			->where('created_at','>=', Carbon::today())
			->where('created_at','<=', Carbon::today()->addDay(1))
			->where('status','<>', 'ANULADO') // NO SE CONSIDERAN LOS ANULADOS
			->where('sellers_agency_id',$id)
			->get();
	
			$total=$ventas[0]->ventas;
			
		return $total;
	
	}
	
	
	/**
	 * Gain of bank for specified agency
	 *
	 * @param  int  $id Agency
	 * @return \Illuminate\Http\Response
	 */
	public static function gainOfBanker($id){
		
		$agency= self::find($id);
		$ventas=self::todaySales($id);
		
		$percentage=($ventas*$agency->percentage_gain)/100;
		$gain=$ventas-$percentage;
			
		return $gain;
	}
	
	/**
	 * Gain of seller for specified agency
	 *
	 * @param  int  $id Agency
	 * @return \Illuminate\Http\Response
	 */
	public static function gainOfSeller($id, $iduser){ // sellers_agency_id
	
		$agency= self::find($id);
		$ventas=self::todaySalesUser($iduser);
	
		$percentage=($ventas*$agency->percentage_gain)/100;

		return $percentage;
	}
	
	
	/**
	 * today's tickets sold for specified agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function todayTickets($id, $status=null, $userid=null){ // sellers_agency_id
		
		$status = !is_null($status) ? array($status) : array('ACTIVO','INACTIVO','ANULADO','CADUCADO'); // caducado no aplica para el día
				
		$total=0;
		$sellers=self::sellersAgency($id); // se recorre por usuario asociado a la agencia
		$array_sellers=array();
		
		if(is_null($userid)){
		
			foreach ($sellers as $seller){ // ventas por usuarios asociados a la agencia
				$array_sellers[]=$seller->id;
			}
		
		}else{
			$array_sellers[]=$userid;
		}
		
		$tickets = \DB::table('sale_invoices')
			->select(\DB::raw("count(*) as tickets"))
			->where('created_at','>=', Carbon::today())
			->where('created_at','<=', Carbon::today()->addDay(1))
			->whereIn('status',$status)
			->whereIn('sellers_agency_id', $array_sellers)
			->get();
			
			$total=$tickets[0]->tickets;
			
		
		return $total;
	}
	
	/**
	 * today's plays sold for specified agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function todayPlays($id, $status=null, $userid=null){ // sellers_agency_id
	
		$status = !is_null($status) ? array($status) : array('ACTIVO','INACTIVO','PREMIADO','PAGADO','ANULADO','CADUCADO');
	
		$total=0;
		$array_sellers=array();
		$array_invoices=array();
		$sellers=self::sellersAgency($id); // se recorre por usuario asociado a la agencia
				
		if(is_null($userid)){
		
			foreach ($sellers as $seller){ // ventas por usuarios asociados a la agencia
				$array_sellers[]=$seller->id;
			}
		
		}else{
			$array_sellers[]=$userid;
		}
		
		
		$invoices = \DB::table('sale_invoices')
		->select('id')
		->where('created_at','>=', Carbon::today())
		->where('created_at','<=', Carbon::today()->addDay(1))
		->whereIn('sellers_agency_id', $array_sellers)
		->get();
		
		foreach ($invoices as $invo){ // recorre jugadas asociadas a las ventas
			$array_invoices[]=$invo->id;
		}
		
		
		
		$sales = \DB::table('sales')
		->select([\DB::raw("count(*) as plays"), \DB::raw("SUM(bet) as ventas")])
		->whereIn('sale_invoice_id', $array_invoices)
		->whereIn('status',$status)
		->get();
		
		return $sales[0];
	}
	
	
	/**
	 * today's sold for specified agency and lottery
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
 	public static function todaySalesLottery($id_agency, $id_categorie, $userid=null){ // sellers_agency_id
		
 		$total=0;
 		
 		$array_sellers=array();
 		$array_invoices=array();
 		$sellers=self::sellersAgency($id_agency); // se recorre por usuario asociado a la agencia
 		
 		if(is_null($userid)){
 
	 		foreach ($sellers as $seller){ // ventas por usuarios asociados a la agencia
	 			$array_sellers[]=$seller->id;
	 		}
	 		
 		}else{
 			$array_sellers[]=$userid;
 		}
 		
 		
 		$invoices = \DB::table('sale_invoices')
 		->select('id')
 		->where('created_at','>=', Carbon::today())
 		->where('created_at','<=', Carbon::today()->addDay(1))
 		->whereIn('sellers_agency_id', $array_sellers)
 		->get();
 		
 		foreach ($invoices as $invo){ // recorre jugadas asociadas a las ventas
 			$array_invoices[]=$invo->id;
 		}
 		
 		
 		
 		
		$sales = \DB::table('sales')
			->leftJoin('articles', 'sales.articles_id', '=', 'articles.id')
			->leftJoin('categories', 'articles.categorie_id', '=', 'categories.id')
			->select(\DB::raw("SUM(bet) as ventas"))
			->where('sales.status','<>', 'ANULADO') // NO SE CONSIDERAN LOS ANULADOS
			->where('categories.id',$id_categorie) // filtro por categoria
			->whereIn('sale_invoice_id', $array_invoices) // filtro por agencia
			->get();
		
		if(isset($sales[0]->ventas) and !is_null($sales[0]->ventas)){
			return $sales[0]->ventas;
		}else{
			return 0;
		}
		
 	}
 	
 	/**
 	 * today's articles sold for specified agency and lottery best seller
 	 *
 	 * @param  int  $id
 	 * @return \Illuminate\Http\Response
 	 */
 	public static function bestSeller($id, $id_categorie, $limit=null, $userid=null){ // sellers_agency_id
 		
 		$total=0;
 		$array_sellers=array();
 		$array_invoices=array();
 		$sellers=self::sellersAgency($id); // se recorre por usuario asociado a la agencia
 		
 		if(is_null($userid)){
 		
 			foreach ($sellers as $seller){ // ventas por usuarios asociados a la agencia
 				$array_sellers[]=$seller->id;
 			}
 		
 		}else{
 			$array_sellers[]=$userid;
 		}
 		
 		
 		$invoices = \DB::table('sale_invoices')
 		->select('id')
 		->where('created_at','>=', Carbon::today())
 		->where('created_at','<=', Carbon::today()->addDay(1))
 		->whereIn('sellers_agency_id', $array_sellers)
 		->get();
 		
 		foreach ($invoices as $invo){ // recorre jugadas asociadas a las ventas
 			$array_invoices[]=$invo->id;
 		}
 		
 		
 		$sales = \DB::table('sales')
 		->leftJoin('articles', 'sales.articles_id', '=', 'articles.id')
 		->leftJoin('categories', 'articles.categorie_id', '=', 'categories.id')
 		->select(['articles_id', 'articles.name as name_article',\DB::raw("count(articles_id) as plays"), \DB::raw("SUM(bet) as ventas")])
 		->where('sales.status','<>', 'ANULADO') // NO SE CONSIDERAN LOS ANULADOS
 		->whereIn('sale_invoice_id', $array_invoices) // filtro por agencia
 		->where('categories.id',$id_categorie) // filtro por categoria
 		->groupBy(['sales.articles_id', 'articles.name'])
		->orderBy('plays','DESC')
		->limit($limit)
 		->get(); // verificar
 		
 		
 		//dd($sales);die();
 		
 		return $sales;
 	}
 	
 	/**
	 * today's plays prizes for specified agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function todayPrizes($id, $total=false, $status=null){ // only PREMIADO, PAGADO
		
		$status = !is_null($status) ? array($status) : array('PREMIADO','PAGADO');
		
		$sum=0;
		
		$prizes = \DB::table('sales')
		->leftJoin('articles', 'sales.articles_id', '=', 'articles.id')
		->leftJoin('categories', 'articles.categorie_id', '=', 'categories.id')
		->leftJoin('agency_categories_sell', 'categories.id', '=', 'agency_categories_sell.categorie_id')
		->select(['sales.id','sales.bet','sales.status', 'articles_id', 'categories.id','agency_categories_sell.agencies_id', 'agency_categories_sell.bet_min', 'agency_categories_sell.prize_min', \DB::raw("((sales.bet*agency_categories_sell.prize_min)/agency_categories_sell.bet_min) as premio")])
		->where('agency_categories_sell.agencies_id',$id)
		->whereIn('sales.status',$status)
		->where('sales.created_at','>=', Carbon::today())
		->where('sales.created_at','<=', Carbon::today()->addDay(1))
		->get();
		
		//dd($prizes); die();
		
		if($total==true){
			
			foreach ($prizes as $prize){
				$sum+=$prize->premio;
			}
			return $sum;
		}else{
			return $prizes;
		}
		
		
		
		
		
	}
	
}

