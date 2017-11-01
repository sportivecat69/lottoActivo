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
        'agencies_id', 'user_id',
    ];
    
    public function agency()
    {
        return $this->hasOne(Agency::class, 'id', 'agencies_id');
    }
}
