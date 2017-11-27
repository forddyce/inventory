<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientRegion extends Model
{
    protected $table = 'Client_Regional';
    protected $fillable = [];
    protected $hidden = [];

    public function parentRegion () {
        return self::where('id', $this->parent_id)->first();
    }

    public function childrenRegion () {
        return self::where('parent_id', $this->id)->orderBy('region_name', 'asc')->get();
    }
}