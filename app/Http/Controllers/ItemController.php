<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ItemRepository;

class ItemController extends Controller
{
    /**
     * The ItemRepository instance.
     *
     * @var \App\Repositories\ItemRepository
     */
    protected $ItemRepository;

    /**
     * Create a new ItemController instance.
     *
     * @param \App\Repositories\ItemRepository $ItemRepository
     * @return void
     */
    public function __construct(
        ItemRepository $ItemRepository
    ) {
        parent::__construct();
        $this->ItemRepository = $ItemRepository;
        $this->middleware('admin');
        $this->middleware('admin.item');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->ItemRepository->getList(
            \Input::get('date_start'),
            \Input::get('date_end')
        );
    }

    /**
     * Creates the item
     * @return json
     */
    public function createItem () {
        $data = \Input::get('data');
        $code = trim($data['item_code']);

        if (!$check = $this->ItemRepository->checkCode($code)) {
            return \Response::json([
                'type' => 'error',
                'message' => "Kode unik item [{$code}] sudah ada."
            ]);
        }

        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;
        
        try {
            $model = $this->ItemRepository->store($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "[{$model->item_name}] telah ditambah.",
        ]);
    }

    /**
     * Edit Item page
     * @param string $id
     * @return html
     */
    public function editItem ($id) {
        if (!$model = $this->ItemRepository->findById(trim($id))) {
            return redirect(route('item.list'))->with('flashMessage', [
                'class' => 'danger',
                'message' => 'Data barang tidak ditemukan.'
            ]);
        }

        return view('item.edit')->with('model', $model);
    }

    /**
     * Updates the item
     * @param string $id
     * @return json
     */
    public function updateItem ($id) {
        if (!$model = $this->ItemRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data item #{$id} tidak ditemukan."
            ]);
        }

        $data = \Input::get('data');
        $code = trim($data['item_code']);

        if (!$check = $this->ItemRepository->checkCode($code, $model->id)) {
            return \Response::json([
                'type' => 'error',
                'message' => "Kode unik item [{$code}] sudah ada."
            ]);
        }

        try {
            $model = $this->ItemRepository->update($model, $data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "[{$model->item_name}] telah diubah.",
        ]);
    }

    /**
     * Delete item
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteItem ($id) {
        if (!$model = $this->ItemRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data item #{$id} tidak ditemukan."
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "Data item telah berhasil dihapus."
        ]);
    }

    /**
     * Sales report by date and year
     * @return html
     */
    public function reportProfit () {
        if (!\Input::has('month') || !\Input::has('year')) {
            return "Data bulan dan tahun tidak ada.";
        }

        $item = null;
        if (\Input::get('item_id') != 0) {
            $itemRepo = new ItemRepository;
            if (!$item = $itemRepo->findById(trim(\Input::get('item_id')))) {
                return "Data item tidak ditemukan.";
            }
        }

        // $purchaseModels = $this->ItemRepository->findReportPurchase(
        //     trim(\Input::get('month')),
        //     trim(\Input::get('year')),
        //     $item
        // );

        $salesModels = $this->ItemRepository->findReportSales(
            trim(\Input::get('month')),
            trim(\Input::get('year')),
            $item
        );

        return view('item.reportProfitDetail')->with('data', [
            // 'purchase' => $purchaseModels,
            'sales' => $salesModels
        ]);
    }

    /**
     * Sales report by date and year
     * @return html
     */
    public function reportPurchase () {
        if (!\Input::has('month') || !\Input::has('year')) {
            return "Data bulan dan tahun tidak ada.";
        }

        $item = null;
        if (\Input::get('item_id') != 0) {
            $itemRepo = new ItemRepository;
            if (!$item = $itemRepo->findById(trim(\Input::get('item_id')))) {
                return "Data item tidak ditemukan.";
            }
        }

        $models = $this->ItemRepository->findReportPurchase(
            trim(\Input::get('month')),
            trim(\Input::get('year')),
            $item
        );

        return view('item.reportPurchase')->with('models', $models);
    }

    /**
     * Sales report by date and year
     * @return html
     */
    public function reportSales () {
        if (!\Input::has('month') || !\Input::has('year')) {
            return "Data bulan dan tahun tidak ada.";
        }

        $item = null;
        if (\Input::get('item_id') != 0) {
            $itemRepo = new ItemRepository;
            if (!$item = $itemRepo->findById(trim(\Input::get('item_id')))) {
                return "Data item tidak ditemukan.";
            }
        }

        $models = $this->ItemRepository->findReportSales(
            trim(\Input::get('month')),
            trim(\Input::get('year')),
            $item
        );

        return view('item.reportSales')->with('models', $models);
    }
}
