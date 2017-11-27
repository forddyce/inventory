<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\ItemSalesHistory;
use App\Models\ItemPurchaseHistory;

use Yajra\DataTables\Facades\DataTables;

class ItemRepository extends BaseRepository
{
    protected $model, $salesModel, $purchaseModel;

    public function __construct() {
        $this->model = new Item;
        $this->salesModel = new ItemSalesHistory;
        $this->purchaseModel = new ItemPurchaseHistory;
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

    public function findByCode ($code) {
        return $this->model->where('item_code', $code)->first();
    }

    public function findAll () {
        return $this->model->orderBy('item_name', 'asc')->get();
    }

    /**
     * [findReportPurchase description]
     * @param integer $month
     * @param integer $year
     * @param App\Models\Item $item
     * @return json
     */
    public function findReportPurchase ($month, $year, $item) {
        $model = $this->purchaseModel;

        if (!is_null($item)) {
            $model = $model->where('item_id', $item->id);
        }
                    
        $model = $model->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();

        return $model;
    }

     /**
     * [findReportPurchase description]
     * @param integer $month
     * @param integer $year
     * @param App\Models\Item $item
     * @return json
     */
    public function findReportSales ($month, $year, $item) {
        $model = $this->salesModel;

        if (!is_null($item)) {
            $model = $model->where('item_id', $item->id);
        }
                    
        $model = $model->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();

        return $model;
    }

    /**
     * Check if unique code exists
     * @param string $code
     * @param integer $idToIgnore
     * @return boolean
     */
    public function checkCode ($code, $idToIgnore=null) {
        $model = $this->model->where('item_code', $code);
        if (!is_null($idToIgnore)) {
            $model = $model->where('id', '!=', $idToIgnore);
        }
        return !$model->first();
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
                    return view('item.action')->with('model', $model);
                })
                ->make(true);
        return $data;
    }

    /**
     * [addPurchaseHistory description]
     * @param array $data
     * @param App\Models\Item $itemModel
     * @param App\Models\Purchase $purchaseModel
     * @return App\Models\ItemPurchaseHistory
     */
    public function addPurchaseHistory ($data, $itemModel, $purchaseModel) {
        $model = new $this->purchaseModel;
        $model->item_id = $itemModel->id;
        $model->purchase_id = $purchaseModel->id;
        $model->invoice_id = $purchaseModel->invoice_id;
        $model->quantity = $data['quantity'];
        $model->unit_price = $data['price'];
        $model->price = $data['price'] * $data['quantity'];
        $model->discount = $data['discount'];
        $model->total = $data['total'];
        $model->save();
        return $model;
    }

    /**
     * [addSalesHistory description]
     * @param array $data
     * @param App\Models\Item $itemModel
     * @param App\Models\Sales $salesModel
     * @return App\Models\ItemSalesHistory
     */
    public function addSalesHistory ($data, $itemModel, $salesModel) {
        $model = new $this->salesModel;
        $model->item_id = $itemModel->id;
        $model->sales_id = $salesModel->id;
        $model->invoice_id = $salesModel->invoice_id;
        $model->quantity = $data['quantity'];
        $model->unit_price = $data['price'];
        $model->price = $data['price'] * $data['quantity'];
        $model->discount = $data['discount'];
        $model->total = $data['total'];
        $model->save();
        return $model;
    }

}