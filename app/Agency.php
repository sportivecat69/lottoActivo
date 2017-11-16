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
		'name' => 'required|min:3|max:50',
		'description' => 'required|min:3|max:200',
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
		
		foreach ($sellers as $seller){
			
			$ventas = \DB::table('sale_invoices')
			->select(\DB::raw("SUM(total) as ventas"))
			->where('created_at','>=', Carbon::today())
			->where('created_at','<=', Carbon::today()->addDay(1))
			->get();
				
			$total=$ventas[0]->ventas;
			
		}
		
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
	 * today's tickets sold for specified agency
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function todayTickets($id, $status=null){
		
		$status = !is_null($status) ? array($status) : array('ACTIVO','INACTIVO','PREMIADO','ANULADO','CADUCADO');
				
		$total=0;
		$sellers=self::sellersAgency($id); // se recorre por usuario asociado a la agencia
		
		foreach ($sellers as $seller){
		
			$tickets = \DB::table('sale_invoices')
			->select(\DB::raw("count(*) as tickets"))
			->where('created_at','>=', Carbon::today())
			->where('created_at','<=', Carbon::today()->addDay(1))
			->whereIn('status',$status)
			->get();
			
			$total=$tickets[0]->tickets;
			
		}
		
		return $total;
	}
}

