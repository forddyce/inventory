<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPurchaseHistory extends Model
{
    protected $table = 'Sales_ItemPurchase_History';
    protected $fillable = [];
    protected $hidden = [];

    protected static $salesModel  = 'App\Models\Sales';
    protected static $purchaseHistoryModel = 'App\Models\ItemPurchaseHistory';

    public function sales () {
        return $this->belongsTo(static::$salesModel, 'sales_id');
    }

    public function purchaseHistory () {
        return $this->belongsTo(static::$purchaseHistoryModel, 'history_id');
    }
}