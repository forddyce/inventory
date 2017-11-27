<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReceivableRepository;
use App\Repositories\ClientRepository;

class ReceivableController extends Controller
{
    /**
     * The ReceivableRepository instance.
     *
     * @var \App\Repositories\ReceivableRepository
     */
    protected $ReceivableRepository;

    /**
     * Create a new ReceivableController instance.
     *
     * @param \App\Repositories\ReceivableRepository $ReceivableRepository
     * @return void
     */
    public function __construct(
        ReceivableRepository $ReceivableRepository
    ) {
        parent::__construct();
        $this->ReceivableRepository = $ReceivableRepository;
        $this->middleware('admin');
        $this->middleware('admin.sales');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->ReceivableRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getInvoiceList () {
        return $this->ReceivableRepository->getInvoiceList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Get Detail
     * @return html
     */
    public function getDetail ($id) {
        if (!$model = $this->ReceivableRepository->findById(trim($id))) {
            return 'Data piutang tidak ditemukan.';
        } else {
            return view('receivable.detail')->with('model', $model);
        }
    }

    /**
     * Get Invoice Detail
     * @return html
     */
    public function getInvoiceDetail ($id) {
        if (!$model = $this->ReceivableRepository->findInvoiceById(trim($id))) {
            return 'Data pelunasan piutang tidak ditemukan.';
        } else {
            return view('receivable.invoiceDetail')->with('model', $model);
        }
    }

    /**
     * Create the Receivable
     * @return json
     */
    public function createReceivable () {
        $data = \Input::get('data');

        if (isset($data['is_client'])) {
            $ClientRepo = new ClientRepository;
            if (!$ClientRepo->findById(trim($data['client_id']))) {
                return \Response::json([
                    'type' => 'error',
                    'message' => 'Data klien tidak ditemukan.'
                ]);
            }
            $data['is_client'] = true;
        } else $data['is_client'] = false;

        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;

        try {
            $model = $this->ReceivableRepository->createReceivable($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "Data piutang telah ditambah.",
        ]);
    }

    /**
     * Edit Receivable page
     * @param string $id
     * @return html
     */
    public function editReceivable ($id) {
        return false;
    }

    /**
     * Update Receivable
     * @param string $id
     * @return json
     */
    public function updateReceivable ($id) {
        return false;
    }

    /**
     * Delete Receivable
     * @param string $id
     * @return json   
     */
    public function deleteReceivable ($id) {
        if (!$model = $this->ReceivableRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Data piutang #{$id} tidak ditemukan.'
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "Data piutang telah berhasil dihapus."
        ]);
    }

    /**
     * Expense report by date and year
     * @return html
     */
    public function reportClient () {
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

        $models = $this->ReceivableRepository->findReportClient(
            trim(\Input::get('month')),
            trim(\Input::get('year')),
            $client
        );

        return view('receivable.reportDetail')->with('models', $models);
    }
}
