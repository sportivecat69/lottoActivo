<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyCategoriesSell extends Model
{
	protected $table = 'agency_categories_sell';
   /**
	 * Rules for model
	 *
	 */
	
	public   $rules = [
		'categorie_id' => 'required|integer',
		//'agencies_id' => 'required|integer',
		'bet_min' => 'required|numeric',
		'prize_min' => 'required|numeric',
	];
	
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'categorie_id', 'agencies_id', 'bet_min', 'prize_min'
	];
	
}
