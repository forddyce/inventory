<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'Purchase';
    protected $fillable = [];
    protected $hidden = [];

    protected static $debtModel = 'App\Models\Debt';
    protected static $supplierModel = 'App\Models\Supplier';
    protected static $itemPurchaseHistoryModel = 'App\Models\ItemPurchaseHistory';

    public function debt () {
        return $this->hasOne(static::$debtModel, 'purchase_id');
    }

    public function items () {
        return $this->hasOne(static::$itemPurchaseHistoryModel, 'purchase_id');
    }

    public function supplier () {
        return $this->belongsTo(static::$supplierModel, 'supplier_id');
    }

    public function delete () {
        $itemHistory = $this->items()->get();
        if (count($itemHistory) > 0) {
            foreach ($itemHistory as $history) {
                if ($item = $history->item) {
                    $item->stock -= $history->quantity;
                    if ($item->stock < 0) $item->stock = 0;
                    $item->save();
                }
                $history->delete();
            }
        }
        $this->debt()->delete();
        return parent::delete();
    }
}