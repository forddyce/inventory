<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtInvoice extends Model
{
    protected $table = 'Debt_Invoice';
    protected $fillable = [];
    protected $hidden = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'paid_date'
    ];

    protected static $supplierModel = 'App\Models\Supplier';

    public function supplier () {
        return $this->belongsTo(static::$supplierModel, 'supplier_id');
    }
}