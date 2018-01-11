<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PurchaseRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\DebtRepository;
use App\Repositories\ItemRepository;

class PurchaseController extends Controller
{
    /**
     * The PurchaseRepository instance.
     *
     * @var \App\Repositories\PurchaseRepository
     */
    protected $PurchaseRepository;

    /**
     * Create a new PurchaseController instance.
     *
     * @param \App\Repositories\PurchaseRepository $PurchaseRepository
     * @return void
     */
    public function __construct(
        PurchaseRepository $PurchaseRepository
    ) {
        parent::__construct();
        $this->PurchaseRepository = $PurchaseRepository;
        $this->middleware('admin');
        $this->middleware('admin.purchase');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->PurchaseRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    public function getInvoice ($id) {
        if (!$model = $this->PurchaseRepository->findById(trim($id))) {
            return "Data pembelian ID #{$id} tidak ditemukan.";
        }
        return view('purchase.invoice')->with('model', $model);
    }

    /**
     * Create the Purchase
     * @return json
     */
    public function createPurchase () {
        $data = \Input::get('data');
        $user = \Sentinel::getUser();

        if ($data['invoice_id'] == '' || $data['supplier_id'] == '') {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data invoice / supplier tidak lengkap.'
            ]);
        }

        if (!isset($data['is_complete']) && (
            $data['paid_date'] == '' || $data['debt_amount'] == '')
        ) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data hutang tidak lengkap.'
            ]);
        }

        $supplierRepo = new SupplierRepository;
        if (!$supplier = $supplierRepo->findById(trim($data['supplier_id']))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data supplier tidak ditemukan.'
            ]);
        }

        /* process Purchase data */
        $PurchaseInfo = json_decode(\Input::get('purchase_info'), 1);

        if (count($PurchaseInfo) <= 0) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data pembelian kosong.'
            ]);
        }

        $totalGross = 0;
        $totalDiscount = 0;
        $totalNet = 0;
        $itemData = [];
        $itemRepo = new ItemRepository;

        /** check each item */
        foreach ($PurchaseInfo as $k=>$Purchase) {
            if (!$item = $itemRepo->findByCode(trim($Purchase['item_code']))) {
                return \Response::json([
                    'type' => 'error',
                    'message' => "Barang {$Purchase['item_id']} tidak ditemukan."
                ]);
                break;
            }

            $item->stock += $Purchase['quantity'];
            $item->last_purchase_price = isset($Purchase['price']) ? $Purchase['price'] : 0;
            array_push($itemData, [
                'purchase_data' => $Purchase, 
                'item' => $item
            ]);

            $totalGross += isset($Purchase['price']) ? $Purchase['price'] : 0;
            $totalDiscount += isset($Purchase['discount']) ? $Purchase['discount'] : 0;
            $totalNet += isset($Purchase['total']) ? $Purchase['total'] : 0;
            $PurchaseInfo[$k]['item_unit'] = $item->item_unit;
        }

        // save purchase data on database
        try {
            $model = $this->PurchaseRepository->store([
                'created_by' => $user->email,
                'supplier_id' => $supplier->id,
                'invoice_id' => $data['invoice_id'],
                'total_price' => $totalGross,
                'total_discount' => $totalDiscount,
                'total_final' => $totalNet,
                'is_complete' => isset($data['is_complete']) ? 1 : 0,
                'purchase_info' => json_encode($PurchaseInfo)
            ]);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        /* add to debt if not complete */
        if (!isset($data['is_complete'])) {
            $debtRepo = new DebtRepository;
            $debtModel = $debtRepo->store([
                'created_by' => $user->email,
                'purchase_id' => $model->id,
                'supplier_id' => $supplier->id,
                'invoice_id' => $data['invoice_id'],
                'amount' => $data['debt_amount'],
                'amount_left' => $data['debt_amount'],
                'due_date' => $data['paid_date']
            ]);
        }

        /* purchase history and update stock */
        foreach ($itemData as $id) {
            $item = $id['item'];
            $item->save();
            $itemRepo->addPurchaseHistory($id['purchase_data'], $item, $model);
        }

        return \Response::json([
            'type' => 'success',
            'message' => 'Data pembelian telah ditambah.',
            'redirect' => route('purchase.all')
        ]);
    }

    /**
     * Edit purchase page
     * @param string $id
     * @return html
     */
    public function editPurchase ($id) {
        return false;
    }

    /**
     * Update the Purchase
     * @return json
     */
    public function updatePurchase ($id) {
        return false;
    }

    /**
     * Delete the Purchase
     * @return json
     */
    public function deletePurchase ($id) {
        if (!$model = $this->PurchaseRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data pembelian #{$id} tidak ditemukan.'
            ]);
        }
        
        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => 'Data penjualan berhasil dihapus.',
        ]);
    }

    /**
     * Purchase report by date and year
     * @return html
     */
    public function report () {
        if (!\Input::has('month') || !\Input::has('year')) {
            return "Data bulan dan tahun tidak ada.";
        }

        $supplier = null;
        if (\Input::get('supplier_id') != 0) {
            $supplierRepo = new SupplierRepository;
            if (!$supplier = $supplierRepo->findById(trim(\Input::get('supplier_id')))) {
                return "Data supplier tidak ditemukan.";
            }
        }

        $models = $this->PurchaseRepository->findReportSupplier(
            trim(\Input::get('month')),
            trim(\Input::get('year')),
            $supplier
        );

        return view('purchase.reportDetail')->with('models', $models);
    }
}
