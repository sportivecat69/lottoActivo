<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			 'cod', 'name', 'categorie_id', 'sale_price', 'status',
	];
	
	public function categorie()
	{
		return $this->hasOne(Categorie::class, 'id', 'categorie_id');
	}
}
