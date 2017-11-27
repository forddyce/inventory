<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSalesHistory extends Model
{
    protected $table = 'Item_Sales_History';
    protected $fillable = [];
    protected $hidden = [];

    protected static $itemModel = 'App\Models\Item';
    protected static $salesModel = 'App\Models\Sales';

    public function item () {
        return $this->belongsTo(static::$itemModel, 'item_id');
    }

    public function sales () {
        return $this->belongsTo(static::$salesModel, 'sales_id');
    }
}