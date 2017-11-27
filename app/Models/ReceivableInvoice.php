<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivableInvoice extends Model
{
    protected $table = 'Receivable_Invoice';
    protected $fillable = [];
    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'paid_date'
    ];

    protected static $clientModel = 'App\Models\Client';

    public function client () {
        return $this->belongsTo(static::$clientModel, 'client_id');
    }
}