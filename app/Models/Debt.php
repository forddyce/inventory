<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'Debt';
    protected $fillable = [];
    protected $hidden = [];
    protected $dates = ['created_at', 'updated_at', 'due_date'];

    protected static $supplierModel = 'App\Models\Supplier';
    protected static $purchaseModel = 'App\Models\Purchase';

    public function supplier () {
        return $this->belongsTo(static::$supplierModel, 'supplier_id');
    }

    public function purchase () {
        return $this->belongsTo(static::$purchaseModel, 'purchase_id');
    }
}