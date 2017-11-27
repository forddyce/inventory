<?php

namespace App\Repositories;

use App\Models\Sales;
use Yajra\DataTables\Facades\DataTables;

class SalesRepository extends BaseRepository
{
    protected $model;

    public function __construct() {
        $this->model = new Sales;
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
     * @param App\Models\Client $client
     * @return json
     */
    public function findReportClient ($month, $year, $client) {
        $model = $this->model;

        if (!is_null($client)) {
            $model = $model->where('client_id', $client->id);
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
                    return view('sales.action')->with('model', $model);
                })
                ->editColumn('is_complete', function ($model) {
                    if ($model->is_complete) {
                        return '<span class="badge badge-success">SELESAI</span>';
                    } else {
                        return '<span class="badge badge-danger">BELUM SELESAI</span>';
                    }
                })
                ->editColumn('client', function ($model) {
                    if ($client = $model->client) {
                        return '<a href="' . route('client.edit', ['id' => $client->id]) . '" target="_blank">' . $client->client_name . '</a>';
                    } else {
                        return '<span class="badge badge-danger">TIDAK ADA KLIEN</span>';
                    }
                })
                ->editColumn('total_net', function ($model) {
                    return number_format($model->total_net, 0);
                })
                ->rawColumns(['is_complete', 'action', 'client'])
                ->make(true);
        return $data;
    }

}