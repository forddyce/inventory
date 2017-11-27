<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'Sales';
    protected $fillable = [];
    protected $hidden = [];

    protected static $receivableModel = 'App\Models\Receivable';
    protected static $clientModel = 'App\Models\Client';
    protected static $itemSalesHistoryModel = 'App\Models\ItemSalesHistory';

    public function receivable () {
        return $this->hasOne(static::$receivableModel, 'sales_id');
    }

    public function items () {
        return $this->hasOne(static::$itemSalesHistoryModel, 'sales_id');
    }

    public function client () {
        return $this->belongsTo(static::$clientModel, 'client_id');
    }

    public function delete () {
        $itemHistory = $this->items()->get();
        if (count($itemHistory) > 0) {
            foreach ($itemHistory as $history) {
                if ($item = $history->item) {
                    $item->stock += $history->quantity;
                    $item->save();
                }
                $history->delete();
            }
        }
        $this->receivable()->delete();
        return parent::delete();
    }
}