<?php

namespace App\Repositories;

use App\Models\Purchase;
use Yajra\DataTables\Facades\DataTables;

class PurchaseRepository extends BaseRepository
{
    protected $model;

    public function __construct() {
        $this->model = new Purchase;
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

    public function findByInvoice ($id) {
        return $this->model->where('invoice_id', $id)->first();
    }

    /**
     * [findReportSupplier description]
     * @param integer $month
     * @param integer $year
     * @param App\Models\Supplier $supplier
     * @return json
     */
    public function findReportSupplier ($month, $year, $supplier) {
        $model = $this->model;

        if (!is_null($supplier)) {
            $model = $model->where('supplier_id', $supplier->id);
        }
                    
        $model = $model->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();

        return $model;
    }

    /**
     * Create unique invoice ID based on last table ID
     * @return string
     */
    public function createInvoiceId () {
        $lastId = $this->model->orderBy('id', 'desc')->pluck('id')->first();
        $lastId += 1;
        $id = 'INV-' . str_pad($lastId, 8, '0', STR_PAD_LEFT);
        $check = $this->findByInvoice($id);

        while ($check) {
            $lastId += 1;
            $id = 'INV-' . str_pad($lastId, 8, '0', STR_PAD_LEFT);
            $check = $this->findByInvoice($id);
        }

        return $id;
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
                    return view('purchase.action')->with('model', $model);
                })
                ->editColumn('is_complete', function ($model) {
                    if ($model->is_complete) {
                        return '<span class="badge badge-success">SELESAI</span>';
                    } else {
                        return '<span class="badge badge-danger">BELUM SELESAI</span>';
                    }
                })
                ->editColumn('supplier', function ($model) {
                    if ($supplier = $model->supplier) {
                        return '<a href="' . route('supplier.edit', ['id' => $supplier->id]) . '" target="_blank">' . $supplier->supplier_name . '</a>';
                    } else {
                        return '<span class="badge badge-danger">TIDAK ADA SUPPLIER</span>';
                    }
                })
                ->editColumn('total_final', function ($model) {
                    return number_format($model->total_final, 0);
                })
                ->rawColumns(['is_complete', 'action', 'supplier'])
                ->make(true);
        return $data;
    }

}