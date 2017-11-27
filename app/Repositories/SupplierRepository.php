<?php

namespace App\Repositories;

use App\Models\Supplier;
use Yajra\DataTables\Facades\DataTables;

class SupplierRepository extends BaseRepository
{
    protected $model;

    public function __construct() {
        $this->model = new Supplier;
    }

    protected function saveModel($model, $data) {
        foreach ($data as $k=>$d) {
            $model->{$k} = $d;
        }
        $model->save();
        return $model;
    }

    public function store($data) {
        $model = $this->saveModel(new $this->model, $data);
        return $model;
    }

    public function update($model, $data) {
        $model = $this->saveModel($model, $data);
        return $model;
    }

    public function findAll () {
        return $this->model->orderBy('supplier_name', 'asc')->get();
    }

    public function findById ($id) {
        return $this->model->where('id', $id)->first();
    }

    public function getList ($from='', $to='') {
        if ($from == '' && $to == '') {
            $query = $this->model->query();
        } else {
            $query = $this->model;
            if ($from != '') {
                $query = $query->whereDate('created_at', '>=', trim($from));
            }
            if ($to != '') {
                $query = $query->whereDate('created_at', '<=', trim($to));
            }
        }
        $data = DataTables::eloquent($query)
                ->addColumn('action', function ($model) {
                    return view('supplier.action')->with('model', $model);
                })
                ->make(true);
        return $data;
    }

}