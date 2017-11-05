<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sellers_agency_id', 'total', 'status',
    ];
    
    public function sellerAgency()
    {
        return $this->hasOne(SellerAgency::class, 'id', 'sellers_agency_id');
    }
}
