<?php

namespace App\Repositories;

use App\Models\Receivable;
use App\Models\ReceivableInvoice;
use Yajra\DataTables\Facades\DataTables;

class ReceivableRepository extends BaseRepository
{
    protected $model, $invoiceModel;

    public function __construct() {
        $this->model = new Receivable;
        $this->invoiceModel = new ReceivableInvoice;
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

    public function storeInvoice($data) {
        $model = $this->saveModel(new $this->invoiceModel, $data);
        return $model;
    }

    public function update($model, $data) {
        $model = $this->saveModel($model, $data);
        return $model;
    }

    public function findInvoiceById ($id) {
        return $this->invoiceModel->where('id', $id)->first();
    }

    public function findById ($id) {
        return $this->model->where('id', $id)->first();
    }

    public function findDue ($days=7) {
        $date = \Carbon\Carbon::today()->addDays($days);
        return $this->model->where('is_complete', false)->where('due_date', '<=', $date)->count();
    }

    /**
     * [findReportClient description]
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
                    return view('receivable.action')->with('model', $model);
                })
                ->editColumn('amount', function ($model) {
                    return number_format($model->amount, 0);
                })
                ->editColumn('amount_left', function ($model) {
                    return number_format($model->amount_left, 0);
                })
                ->editColumn('client_name', function ($model) {
                    if ($client = $model->client) {
                        return '<a href="' . route('client.edit', ['id' => $client->id ]) . '" target="_blank">' . $client->client_name . '</a>';
                    } else {
                        return '<label class="label label-danger">TIDAK ADA DATA KLIEN</label>';
                    }
                })
                ->editColumn('is_complete', function ($model) {
                    if ($model->is_complete) {
                        return '<span class="badge badge-success">LUNAS</span>';
                    } else {
                        return '<span class="badge badge-danger">BELUM LUNAS</span>';
                    }
                })
                ->rawColumns(['action', 'client_name', 'is_complete'])
                ->make(true);
        return $data;
    }

    public function getInvoiceList ($from='', $to='') {
        if ($from == '' && $to == '') {
            $query = $this->invoiceModel->query();
        } else {
            $query = $this->invoiceModel;
            if ($from != '') {
                $query = $query->whereDate('created_at', '>=', trim($from));
            }
            if ($to != '') {
                $query = $query->whereDate('created_at', '<=', trim($to));
            }
        }
        $data = DataTables::eloquent($query)
                ->addColumn('action', function ($model) {
                    return view('receivable.invoiceAction')->with('model', $model);
                })
                ->editColumn('amount', function ($model) {
                    return number_format($model->amount, 0);
                })
                ->editColumn('amount_left', function ($model) {
                    return number_format($model->amount_left, 0);
                })
                ->editColumn('client_name', function ($model) {
                    if ($client = $model->client) {
                        return '<a href="' . route('client.edit', ['id' => $client->id ]) . '" target="_blank">' . $client->client_name . '</a>';
                    } else {
                        return '<label class="label label-danger">TIDAK ADA DATA client</label>';
                    }
                })
                ->rawColumns(['action', 'client_name'])
                ->make(true);
        return $data;
    }

    /**
     * [createReceivable description]
     * @param array $data
     * @return App\Models\ReceivableInvoice
     */
    public function createReceivable ($data) {
        $amountLeft = $data['amount'];

        if ($data['is_client']) { // process client receivable
            $receivablesLeft = $this->model->where('is_complete', 0)
            ->where('client_id', $data['client_id'])
            ->orderBy('created_at', 'asc')
            ->get();

            $infos = [];

            if (count($receivablesLeft) > 0) {
                foreach ($receivablesLeft as $receivable) {
                    if ($amountLeft > $receivable->amount_left) {
                        array_push($infos, [
                            'receivable_id' => $receivable->id,
                            'invoice_id' => $receivable->invoice_id,
                            'amount' => $receivable->amount_left
                        ]);
                        $amountLeft -= $receivable->amount_left;
                        $receivable->amount_left = 0;
                        $receivable->is_complete = true;
                        $receivable->save();
                    } else {
                        array_push($infos, [
                            'receivable_id' => $receivable->id,
                            'invoice_id' => $receivable->invoice_id,
                            'amount' => $amountLeft
                        ]);
                        $receivable->amount_left -= $amountLeft;
                        if ($receivable->amount_left < 0) $receivable->amount_left = 0; // unlikely
                        $amountLeft = 0;
                        $receivable->save();
                        break;
                    }
                }
            }

            $invoiceModel = $this->storeInvoice([
                'created_by' => $data['created_by'],
                'client_id' => $data['client_id'],
                'receivable_infos' => json_encode($infos),
                'other_title' => $data['other_title'],
                'other_notes' => $data['other_notes'],
                'amount' => $data['amount'],
                'amount_left' => $amountLeft,
                'is_client' => true,
                'paid_date' => $data['paid_date']
            ]);
        } else {
            $invoiceModel = $this->storeInvoice([
                'created_by' => $data['created_by'],
                'client_id' => 0,
                'receivable_infos' => null,
                'other_title' => $data['other_title'],
                'other_notes' => $data['other_notes'],
                'amount' => $data['amount'],
                'amount_left' => $data['amount'],
                'is_client' => false,
                'paid_date' => $data['paid_date']
            ]);
        }

        return $invoiceModel;
    }

}