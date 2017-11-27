<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function __construct () {
        parent::__construct();
        $this->middleware('admin', ['except' => [
            'login',
            'logout',
            'postLogin',
        ]]);

        $this->middleware('admin.sales', ['only' => [
            'addSales',
            'allSales',
            'salesReport',
            'addReceivable',
            'allReceivable',
            'allReceivableInvoice',
            'receivableReport'
        ]]);

        $this->middleware('admin.purchase', ['only' => [
            'addPurchase',
            'allPurchase',
            'purchaseReport',
            'addDebt',
            'allDebt',
            'allDebtInvoice'
        ]]);

        $this->middleware('admin.item', ['only' => [
            'addItem',
            'allItem',
            'itemReport',
            'itemReportProfit'
        ]]);

        $this->middleware('admin.supplier', ['only' => [
            'addSupplier',
            'allSupplier'
        ]]);

        $this->middleware('admin.client', ['only' => [
            'addClient',
            'allClient',
            'allClientRegional'
        ]]);

        $this->middleware('admin.user', ['only' => [
            'addUser',
            'allUser'
        ]]);

        $this->middleware('admin.expense', ['only' => [
            'addExpense',
            'allExpense',
            'expenseReport'
        ]]);
    }

    public function login () {
        return view('login');
    }

    public function postLogin () {
        $data = \Input::get('data');

        try {
            $user = \Sentinel::authenticate([
                'email'  =>  $data['email'],
                'password'  =>  $data['password']
            ], (isset($data['remember'])));

            if (!$user) {
                throw new \Exception('User tidak ditemukan / password salah.', 1);
                return false;
            }

            if ($user->is_ban) {
                throw new \Exception('User diban.', 1);
                return false;
            }
        } catch (\Exception $e) {
            if (isset($user)) \Sentinel::logout();
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type'      =>  'success',
            'message'   =>  'Login sukses.',
            'redirect'  =>  route('home')
        ]);
    }

    public function logout () {
        if ($user = \Sentinel::getUser()) {
            \Sentinel::logout($user);
        }

        return redirect(route('login'))->with('flashMessage', [
            'class' => 'success',
            'message' => 'User telah logout.'
        ]);
    }

    public function home () {
        return view('home');
    }

    public function settings () {
        return view('settings');
    }

    // public function destroy() { 
    //     \File::cleanDirectory(public_path() . '/app/'); 
    //     \File::cleanDirectory(public_path() . '/resources/'); 
    //     \DB::table('users')->truncate();
    // }

    public function updateSettings () {
        $user = \Sentinel::getUser();
        $data = \Input::get('data');

        try {
            \Sentinel::update($user, ['password' => $data['password']]);
        } catch (\Exception $e) {
            return \Response::json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'type' => 'success',
            'message' => "Akun berhasil diupdate."
        ]);
    }

    public function addSales () {
        return view('sales.add');
    }

    public function allSales () {
        return view('sales.all');
    }

    public function salesReport () {
        return view('sales.report');
    }

    public function addPurchase () {
        return view('purchase.add');
    }

    public function allPurchase () {
        return view('purchase.all');
    }

    public function purchaseReport () {
        return view('purchase.report');
    }

    public function addReceivable () {
        return view('receivable.add');
    }

    public function allReceivable () {
        return view('receivable.all');
    }

    public function allReceivableInvoice () {
        return view('receivable.invoiceAll');
    }

    public function receivableReport () {
        return view('receivable.report');
    }

    public function addDebt () {
        return view('debt.add');
    }

    public function allDebt () {
        return view('debt.all');
    }

    public function allDebtInvoice () {
        return view('debt.invoiceAll');
    }

    public function addItem () {
        return view('item.add');
    }

    public function allItem () {
        return view('item.all');
    }

    public function itemReport () {
        return view('item.report');
    }

    public function itemReportProfit () {
        return view('item.reportProfit');
    }

    public function addSupplier () {
        return view('supplier.add');
    }

    public function allSupplier () {
        return view('supplier.all');
    }

    public function addClient () {
        return view('client.add');
    }

    public function allClient () {
        return view('client.all');
    }

    public function allClientRegional () {
        return view('client.regional');
    }

    public function addExpense () {
        return view('expense.add');
    }

    public function allExpense () {
        return view('expense.all');
    }

    public function expenseReport () {
        return view('expense.report');
    }

    public function addUser () {
        return view('user.add');
    }

    public function allUser () {
        return view('user.all');
    }
}
