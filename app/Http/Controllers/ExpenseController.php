<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ExpenseRepository;

class ExpenseController extends Controller
{
    /**
     * The ExpenseRepository instance.
     *
     * @var \App\Repositories\ExpenseRepository
     */
    protected $ExpenseRepository;

    /**
     * Create a new ExpenseController instance.
     *
     * @param \App\Repositories\ExpenseRepository $ExpenseRepository
     * @return void
     */
    public function __construct(
        ExpenseRepository $ExpenseRepository
    ) {
        parent::__construct();
        $this->ExpenseRepository = $ExpenseRepository;
        $this->middleware('admin');
        $this->middleware('admin.expense');
    }

    /**
     * Get datatable list
     * @return json
     */
    public function getList () {
        return $this->ExpenseRepository->getList(
            \Input::get('date_start'), 
            \Input::get('date_end')
        );
    }

    /**
     * Create the Expense
     * @return json
     */
    public function createExpense () {
        $data = \Input::get('data');

        $user = \Sentinel::getUser();
        $data['created_by'] = $user->email;

        try {
            $model = $this->ExpenseRepository->store($data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "Data biaya telah ditambah.",
            'redirect' => route('expense.all')
        ]);
    }

    /**
     * Edit Expense page
     * @param string $id
     * @return html
     */
    public function editExpense ($id) {
        if (!$model = $this->ExpenseRepository->findById(trim($id))) {
            return redirect(route('expense.list'))->with('flashMessage', [
                'class' => 'danger',
                'message' => "Data biaya tidak ditemukan."
            ]);
        }

        return view('expense.edit')->with('model', $model);
    }

    /**
     * Update Expense
     * @param string $id
     * @return json
     */
    public function updateExpense ($id) {
        if (!$model = $this->ExpenseRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data biaya #{$id} tidak ditemukan."
            ]);
        }

        $data = \Input::get('data');

        try {
            $model = $this->ExpenseRepository->update($model,  $data);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "Data biaya #{$model->id} telah diubah.",
        ]);
    }

    /**
     * Delete Expense
     * @param string $id
     * @return json   
     */
    public function deleteExpense ($id) {
        if (!$model = $this->ExpenseRepository->findById(trim($id))) {
            return \Response::json([
                'type' => 'error',
                'message' => "Data biaya #{$id} tidak ditemukan."
            ]);
        }

        $model->delete();

        return \Response::json([
            'type' => 'success',
            'message' => "Data biaya telah berhasil dihapus."
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

        $models = $this->ExpenseRepository->findByPeriod(
            trim(\Input::get('month')),
            trim(\Input::get('year'))
        );

        return view('expense.reportDetail')->with('models', $models);
    }
}
