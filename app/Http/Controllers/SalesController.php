<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SalesRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ReceivableRepository;
use App\Repositories\ItemRepository;

class SalesController extends Controller
{
    /**
     * The SalesRepository instance.
     *
     * @var \App\Repositories\SalesRepository
     */
    protected $SalesRepository;

    /**
     * Create a new SalesController instance.
     *
     * @param \App\Repositories\SalesRepository $SalesRepository
     * @return void
     */
    public function __construct(
        SalesRepository $SalesRepository
    ) {
        parent::__construct();
        $this->SalesRepository = $SalesRepository;
        $this->middleware('admin');
        $this->middleware('admin.sales');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->SalesRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    public function getInvoice ($id) {
        if (!$model = $this->SalesRepository->findById(trim($id))) {
            return "Data penjualan ID #{$id} tidak ditemukan.";
        }
        return view('sales.invoice')->with('model', $model);
    }

    /**
     * Create the Sales
     * @return json
     */
    public function createSales () {
        $user = \Sentinel::getUser();
        $data = \Input::get('data');

        if (!isset($data['client_id'])) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data klien tidak lengkap.'
            ]);
        }

        if (!isset($data['is_complete']) && (
            $data['paid_date'] == '' || $data['receivable_amount'] == '')
        ) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data piutang tidak lengkap.'
            ]);
        }

        $ClientRepo = new ClientRepository;
        if (!$client = $ClientRepo->findById(trim($data['client_id']))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data klien tidak ditemukan."
            ]);
        }

        /* process sales data */
        $salesInfo = json_decode(\Input::get('sales_info'), 1);

        if (count($salesInfo) <= 0) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data penjualan kosong."
            ]);
        }

        $totalGross = 0;
        $totalDiscount = 0;
        $totalNet = 0;
        $itemData = [];
        $itemRepo = new ItemRepository;

        foreach ($salesInfo as $k=>$sales) {
            if (!$item = $itemRepo->findByCode(trim($sales['item_code']))) {
                return \Response::json([
                    'type' => 'error',
                    'message' => "Barang {$sales['item_id']} tidak ditemukan."
                ]);
                break;
            }

            if ($item->stock < $sales['quantity']) {
                return \Response::json([
                    'type' => 'error',
                    'message' => "Barang {$sales['item_name']} tersisa {$item->stock}, di-input [{$sales['quantity']}]."
                ]);
            }

            $item->stock -= $sales['quantity'];
            if ($item->stock < 0) $item->stock = 0;
            $item->last_sales_price = isset($sales['price']) ? $sales['price'] : 0;
            array_push($itemData, [
                'sales_data' => $sales, 
                'item' => $item
            ]);

            $totalGross += isset($sales['price']) ? $sales['price'] : 0;
            $totalDiscount += isset($sales['discount']) ? $sales['discount'] : 0;
            $totalNet += isset($sales['total']) ? $sales['total'] : 0;
            $salesInfo[$k]['item_unit'] = $item->item_unit;
        }

        $invoiceId = $this->SalesRepository->createInvoiceId();

        try {
            $model = $this->SalesRepository->store([
                'created_by' => $user->email,
                'client_id' => $client->id,
                'invoice_id' => $invoiceId,
                'total_gross' => $totalGross,
                'total_discount' => $totalDiscount,
                'total_net' => $totalNet,
                'is_complete' => isset($data['is_complete']) ? 1 : 0,
                'sales_info' => json_encode($salesInfo)
            ]);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        /* add to receivable if not complete */
        if (!isset($data['is_complete'])) {
            $receivableRepo = new ReceivableRepository;
            $receivableModel = $receivableRepo->store([
                'created_by' => $user->email,
                'sales_id' => $model->id,
                'client_id' => $client->id,
                'amount' => $data['receivable_amount'],
                'amount_left' => $data['receivable_amount'],
                'invoice_id' => $invoiceId,
                'due_date' => $data['paid_date']
            ]);
        }

        /* sales history and update stock */
        foreach ($itemData as $id) {
            $item = $id['item'];
            $item->save();
            $itemRepo->addSalesHistory($id['sales_data'], $item, $model);
        }

        return \Response::json([
            'type' => 'success',
            'message' => 'Data penjualan telah ditambah.',
            'redirect' => route('sales.all')
        ]);
    }

    /**
     * Edit Sales page
     * @param string $id
     * @return html
     */
    public function editSales ($id) {
        return false;
    }

    /**
     * Update the Sales
     * @return json
     */
    public function updateSales ($id) {
        return false;
    }

    /**
     * Delete the Sales
     * @return json
     */
    public function deleteSales ($id) {
        if (!$model = $this->SalesRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data penjualan #{$id} tidak ditemukan."
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "Data penjualan berhasil dihapus.",
        ]);
    }

    /**
     * Expense report by date and year
     * @return html
     */
    public function report () {
        if (!\Input::has('month') || !\Input::has('year')) {
            return "Data bulan dan tahun tidak ada.";
        }

        $client = null;
        if (\Input::get('client_id') != 0) {
            $clientRepo = new ClientRepository;
            if (!$client = $clientRepo->findById(trim(\Input::get('client_id')))) {
                return "Data klien tidak ditemukan.";
            }
        }

        $models = $this->SalesRepository->findReportClient(
            trim(\Input::get('month')),
            trim(\Input::get('year')),
            $client
        );

        return view('sales.reportDetail')->with('models', $models);
    }
}
