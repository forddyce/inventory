<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DebtRepository;
use App\Repositories\SupplierRepository;

class DebtController extends Controller
{
    /**
     * The DebtRepository instance.
     *
     * @var \App\Repositories\DebtRepository
     */
    protected $DebtRepository;

    /**
     * Create a new DebtController instance.
     *
     * @param \App\Repositories\DebtRepository $DebtRepository
     * @return void
     */
    public function __construct(
        DebtRepository $DebtRepository
    ) {
        parent::__construct();
        $this->DebtRepository = $DebtRepository;
        $this->middleware('admin');
        $this->middleware('admin.purchase');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->DebtRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getInvoiceList () {
        return $this->DebtRepository->getInvoiceList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Get Detail
     * @return html
     */
    public function getDetail ($id) {
        if (!$model = $this->DebtRepository->findById(trim($id))) {
            return 'Data hutang tidak ditemukan.';
        } else {
            return view('debt.detail')->with('model', $model);
        }
    }

    /**
     * Get Invoice Detail
     * @return html
     */
    public function getInvoiceDetail ($id) {
        if (!$model = $this->DebtRepository->findInvoiceById(trim($id))) {
            return 'Data pelunasan hutang tidak ditemukan.';
        } else {
            return view('debt.invoiceDetail')->with('model', $model);
        }
    }

    /**
     * Create the Debt
     * @return json
     */
    public function createDebt () {
        $data = \Input::get('data');

        if (isset($data['is_supplier'])) {
            $SupplierRepo = new SupplierRepository;
            if (!$SupplierRepo->findById(trim($data['supplier_id']))) {
                return \Response::json([
                    'type' => 'error',
                    'message' => 'Data supplier tidak ditemukan.'
                ]);
            }
            $data['is_supplier'] = true;
        } else $data['is_supplier'] = false;

        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;
        
        try {
            $model = $this->DebtRepository->createDebt($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => 'Data hutang telah ditambah.',
        ]);
    }

    /**
     * Edit debt page
     * @param string $id
     * @return html
     */
    public function editDebt ($id) {
        return false;
    }

    /**
     * Update Debt
     * @param string $id
     * @return json
     */
    public function updateDebt ($id) {
        return false;
    }

    /**
     * Delete Debt
     * @param string $id
     * @return json   
     */
    public function deleteDebt ($id) {
        if (!$model = $this->DebtRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data hutang #{$id} tidak ditemukan.'
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => 'Data hutang telah berhasil dihapus.'
        ]);
    }
}
