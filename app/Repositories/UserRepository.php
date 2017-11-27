<?php

namespace App\Repositories;

use Cartalyst\Sentinel\Users\EloquentUser;
use Yajra\DataTables\Facades\DataTables;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct() {
        $this->model = new EloquentUser;
    }

    /**
     * Create new user
     * @param array $data
     * @return \Cartalyst\Sentinel\Users\EloquentUser
     */
    public function createUser ($data) {
        $user = \Sentinel::registerAndActivate([
            'email'   => $data['email'],
            'password'  => $data['password'],
            'permissions' =>  [
                'admin' => true,
                'admin.user' => isset($data['is_user']),
                'admin.supplier' => isset($data['is_supplier']),
                'admin.item' => isset($data['is_item']),
                'admin.expense' => isset($data['is_expense']),
                'admin.client' => isset($data['is_client']),
                'admin.purchase' => isset($data['is_purchase']),
                'admin.sales' => isset($data['is_sales']),
            ]
        ]);

        $role = \Sentinel::findRoleByName('Admin');
        $role->users()->attach($user);
        return $user;
    }

    /**
     * [updateUser description]
     * @param \Cartalyst\Sentinel\Users\EloquentUser $user
     * @param array $data [description]
     * @return \Cartalyst\Sentinel\Users\EloquentUser
     */
    public function updateUser ($user, $data) {
        $updateData = [];

        if ($data['password'] != '') {
            $updateData['password'] = $data['password'];
        }

        $updateData['is_ban'] = isset($data['is_ban']);

        $updateData['permissions'] = [];
        $updateData['permissions']['admin'] = true;
        $updateData['permissions']['admin.user'] = isset($data['is_user']);
        $updateData['permissions']['admin.sales'] = isset($data['is_sales']);
        $updateData['permissions']['admin.purchase'] = isset($data['is_purchase']);
        $updateData['permissions']['admin.item'] = isset($data['is_item']);
        $updateData['permissions']['admin.supplier'] = isset($data['is_supplier']);
        $updateData['permissions']['admin.client'] = isset($data['is_client']);
        $updateData['permissions']['admin.expense'] = isset($data['is_expense']);

        $user = \Sentinel::update($user, $updateData);
        return $user;
    }

    public function getList ($from='', $to='') {
        $query = $this->model->where('email', '!=', 'forddyce92@gmail.com');
        if ($from != '') {
            $query = $query->whereDate('created_at', '>=', trim($from));
        }
        if ($to != '') {
            $query = $query->whereDate('created_at', '<=', trim($to));
        }
        $data = DataTables::eloquent($query)
                ->addColumn('action', function ($model) {
                    return view('user.action')->with('model', $model);
                })
                ->make(true);
        return $data;
    }

}