<?php

namespace App\Security;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;

class RolesUsuario extends Model
{
	protected $table = 'role_user';
	
	protected $fillable = [
	'user_id',
	'role_id',
	];
	
}