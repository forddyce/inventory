<?php

namespace App\Repositories;

use App\Models\Expense;
use Yajra\DataTables\Facades\DataTables;

class ExpenseRepository extends BaseRepository
{
    protected $model;

    public function __construct() {
        $this->model = new Expense;
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

    public function findById ($id) {
        return $this->model->where('id', $id)->first();
    }

    public function findByPeriod ($month, $year) {
        return $this->model->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
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
                    return view('expense.action')->with('model', $model);
                })
                ->editColumn('amount', function ($model) {
                    return number_format($model->amount, 0);
                })
                ->make(true);
        return $data;
    }

}