<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SupplierRepository;

class SupplierController extends Controller
{
    /**
     * The SupplierRepository instance.
     *
     * @var \App\Repositories\SupplierRepository
     */
    protected $SupplierRepository;

    /**
     * Create a new SupplierController instance.
     *
     * @param \App\Repositories\SupplierRepository $SupplierRepository
     * @return void
     */
    public function __construct(
        SupplierRepository $SupplierRepository
    ) {
        parent::__construct();
        $this->SupplierRepository = $SupplierRepository;
        $this->middleware('admin');
        $this->middleware('admin.supplier');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->SupplierRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Create the Supplier
     * @return json
     */
    public function createSupplier () {
        $data = \Input::get('data');
        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;

        try {
            $model = $this->SupplierRepository->store($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "Supplier [{$model->supplier_name}] telah ditambah.",
        ]);
    }

    /**
     * Edit Supplier page
     * @param string $id
     * @return html
     */
    public function editSupplier ($id) {
        if (!$model = $this->SupplierRepository->findById(trim($id))) {
            return redirect(route('supplier.all'))->with('flashMessage', [
                'class' => 'danger',
                'message' => 'Data supplier tidak ditemukan.'
            ]);
        }

        return view('supplier.edit')->with('model', $model);
    }

    /**
     * Update Supplier
     * @param string $id
     * @return json
     */
    public function updateSupplier ($id) {
        if (!$model = $this->SupplierRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data supplier #{$id} tidak ditemukan."
            ]);
        }

        $data = \Input::get('data');

        try {
            $model = $this->SupplierRepository->update($model,  $data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "Data supplier [{$model->supplier_name}] telah diubah.",
        ]);
    }

    /**
     * Delete Supplier
     * @param string $id
     * @return json   
     */
    public function deleteSupplier ($id) {
        if (!$model = $this->SupplierRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data supplier #{$id} tidak ditemukan."
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "Data supplier telah berhasil dihapus."
        ]);
    }
}
