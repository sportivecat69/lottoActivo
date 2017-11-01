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
		'description' => 'required|alpha|min:3|max:200',
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
}

