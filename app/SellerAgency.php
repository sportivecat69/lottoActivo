<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerAgency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sellers_agency';
    protected $fillable = [
        'agencies_id', 'users_id', 'printer_id'
    ];
    
    public function agency()
    {
        return $this->hasOne(Agency::class, 'id', 'agencies_id');
    }
    
    public function user()
    {
    	return $this->hasOne(User::class, 'id', 'users_id');
    }
    
    public function printer()
    {
    	return $this->hasOne(Printer::class, 'id', 'printer_id');
    }
}
