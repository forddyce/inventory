<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientRegion;
use Yajra\DataTables\Facades\DataTables;

class ClientRepository extends BaseRepository
{
    protected $model;
    protected $regionModel;

    public function __construct() {
        $this->model = new Client;
        $this->regionModel = new ClientRegion;
    }

    protected function saveModel($model, $data) {
        foreach ($data as $k=>$d) {
            $model->{$k} = $d;
        }
        $model->save();
        return $model;
    }

    public function store ($data) {
        $model = $this->saveModel(new $this->model, $data);
        return $model;
    }

    public function storeRegional ($data) {
        $model = $this->saveModel(new $this->regionModel, $data);
        return $model;
    }

    public function update ($model, $data) {
        $model = $this->saveModel($model, $data);
        return $model;
    }

    public function findAll () {
        return $this->model->orderBy('client_name', 'asc')->get();
    }

    public function findById ($id) {
        return $this->model->where('id', $id)->first();
    }

    public function findRegionById ($id) {
        return $this->regionModel->where('id', $id)->first();
    }

    public function findAllRegionParent () {
        return $this->regionModel->where('is_parent', true)->orderBy('region_name', 'asc')->get();
    }

    public function getClientList ($from='', $to='') {
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
                    return view('client.action')->with('model', $model);
                })
                ->make(true);
        return $data;
    }

    public function getRegionList ($from='', $to='') {
        if ($from == '' && $to == '') {
            $query = $this->regionModel->query();
        } else {
            $query = $this->regionModel;
            if ($from != '') {
                $query = $query->whereDate('created_at', '>=', trim($from));
            }
            if ($to != '') {
                $query = $query->whereDate('created_at', '<=', trim($to));
            }
        }

        $data = DataTables::eloquent($query)
                ->addColumn('action', function ($model) {
                    return view('client.regionAction')->with('model', $model);
                })
                ->addColumn('parent_name', function ($model) {
                    if ($model->is_parent) return 'Daerah parent';
                    else {
                        $parent = $model->parentRegion();
                        if ($parent) return $parent->region_name;
                        else return 'Parent tidak ditemukan.';
                    }
                })
                ->make(true);
        return $data;
    }

}