<?php

namespace App\Repositories;

use App\Models\Debt;
use App\Models\DebtInvoice;
use Yajra\DataTables\Facades\DataTables;

class DebtRepository extends BaseRepository
{
    protected $model, $invoiceModel;

    public function __construct() {
        $this->model = new Debt;
        $this->invoiceModel = new DebtInvoice;
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
                    return view('debt.action')->with('model', $model);
                })
                ->editColumn('amount', function ($model) {
                    return number_format($model->amount, 0);
                })
                ->editColumn('amount_left', function ($model) {
                    return number_format($model->amount_left, 0);
                })
                ->editColumn('supplier_name', function ($model) {
                    if ($supplier = $model->supplier) {
                        return '<a href="' . route('supplier.edit', ['id' => $supplier->id ]) . '" target="_blank">' . $supplier->supplier_name . '</a>';
                    } else {
                        return '<label class="label label-danger">TIDAK ADA DATA SUPPLIER</label>';
                    }
                })
                ->editColumn('is_complete', function ($model) {
                    if ($model->is_complete) {
                        return '<span class="badge badge-success">LUNAS</span>';
                    } else {
                        return '<span class="badge badge-danger">BELUM LUNAS</span>';
                    }
                })
                ->rawColumns(['action', 'supplier_name', 'is_complete'])
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
                    return view('debt.invoiceAction')->with('model', $model);
                })
                ->editColumn('amount', function ($model) {
                    return number_format($model->amount, 0);
                })
                ->editColumn('amount_left', function ($model) {
                    return number_format($model->amount_left, 0);
                })
                ->editColumn('supplier_name', function ($model) {
                    if ($supplier = $model->supplier) {
                        return '<a href="' . route('supplier.edit', ['id' => $supplier->id ]) . '" target="_blank">' . $supplier->supplier_name . '</a>';
                    } else {
                        return '<label class="label label-danger">TIDAK ADA DATA SUPPLIER</label>';
                    }
                })
                ->rawColumns(['action', 'supplier_name'])
                ->make(true);
        return $data;
    }

    /**
     * [createDebt description]
     * @param array $data
     * @return App\Models\DebtInvoice
     */
    public function createDebt ($data) {
        $amountLeft = $data['amount'];

        if ($data['is_supplier']) { // process supplier debt
            $debtsLeft = $this->model->where('is_complete', 0)
            ->where('supplier_id', $data['supplier_id'])
            ->orderBy('created_at', 'asc')
            ->get();

            $infos = [];

            if (count($debtsLeft) > 0) {
                foreach ($debtsLeft as $debt) {
                    if ($amountLeft > $debt->amount_left) {
                        array_push($infos, [
                            'debt_id' => $debt->id,
                            'invoice_id' => $debt->invoice_id,
                            'amount' => $debt->amount_left
                        ]);
                        $amountLeft -= $debt->amount_left;
                        $debt->amount_left = 0;
                        $debt->is_complete = true;
                        if ($purchase = $debt->purchase) {
                            $purchase->is_complete = true;
                            $purchase->save();
                        }
                        $debt->save();
                    } else {
                        array_push($infos, [
                            'debt_id' => $debt->id,
                            'invoice_id' => $debt->invoice_id,
                            'amount' => $amountLeft
                        ]);
                        $debt->amount_left -= $amountLeft;
                        if ($debt->amount_left < 0) $debt->amount_left = 0; // unlikely
                        $amountLeft = 0;
                        $debt->save();
                        break;
                    }
                }
            }

            $invoiceModel = $this->storeInvoice([
                'created_by' => $data['created_by'],
                'supplier_id' => $data['supplier_id'],
                'debt_infos' => json_encode($infos),
                'other_title' => $data['other_title'],
                'other_notes' => $data['other_notes'],
                'amount' => $data['amount'],
                'amount_left' => $amountLeft,
                'is_supplier' => true,
                'paid_date' => $data['paid_date']
            ]);
        } else {
            $invoiceModel = $this->storeInvoice([
                'created_by' => $data['created_by'],
                'supplier_id' => 0,
                'debt_infos' => null,
                'other_title' => $data['other_title'],
                'other_notes' => $data['other_notes'],
                'amount' => $data['amount'],
                'amount_left' => $data['amount'],
                'is_supplier' => false,
                'paid_date' => $data['paid_date']
            ]);
        }

        return $invoiceModel;
    }

}