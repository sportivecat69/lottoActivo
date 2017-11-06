<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /**
	 * Rules for model
	 *
	 */
	
	public   $rules = [
		'name' => 'required|alpha|min:3|unique:printers,name',
		'folder' => 'alpha|min:3',
		'notes' => 'alpha|min:3'
	];
	
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'folder', 'notes'
	];
}
