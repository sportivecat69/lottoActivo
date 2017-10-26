<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'sale_invoice_id', 'draws_id', 'articles_id', 'bet', 'status',
	];
}
