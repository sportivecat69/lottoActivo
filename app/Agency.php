<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
	/**
	 * Rules for model
	 *
	 */
	
	public   $rules = [
		'name' => 'required|alpha_dash|min:3|max:50',
		'description' => 'required|alpha_dash|min:3|max:200',
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
	
	public function insert($request){
		
		$agency = new self();
		
		foreach ($request->request as $key=>$value){
			if($key!='_token'):
				$agency->setAttribute($key, $value);
			endif;
		}

 		return $agency->save();
		
	}
}

