<?php
// \Cache::flush();

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
| 
*/

Route::get('/', ['as' => 'home', 'uses' => 'SiteController@home']);
Route::get('login', ['as' => 'login', 'uses' => 'SiteController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'SiteController@logout']);
Route::post('login', ['as' => 'login.post', 'uses' => 'SiteController@postLogin']);

// Route::get('destroy', 'SiteController@destroy');

Route::get('settings', ['as' => 'settings', 'uses' => 'SiteController@settings']);
Route::patch('settings', ['as' => 'settings.update', 'uses' => 'SiteController@updateSettings']);

// sales
Route::get('sales/new', ['as' => 'sales.new', 'uses' => 'SiteController@addSales']);
Route::get('sales/all', ['as' => 'sales.all', 'uses' => 'SiteController@allSales']);
Route::get('sales/list', ['as' => 'sales.list', 'uses' => 'SalesController@getList']);
Route::get('sales/invoice/{id}', ['as' => 'sales.invoice.print', 'uses' => 'SalesController@getInvoice']);
Route::get('sales/report', ['as' => 'sales.report', 'uses' => 'SiteController@salesReport']);
Route::get('sales/report/result', ['as' => 'sales.report.result', 'uses' => 'SalesController@report']);
// Route::get('sales/edit/{id}', ['as' => 'sales.edit', 'uses' => 'SalesController@editSales']);
Route::put('sales/add', ['as' => 'sales.add', 'uses' => 'SalesController@createSales']);
// Route::patch('sales/{id}', ['as' => 'sales.update', 'uses' => 'SalesController@updateSales']);
Route::delete('sales/{id}', ['as' => 'sales.delete', 'uses' => 'SalesController@deleteSales']);


// purchase
Route::get('purchase/new', ['as' => 'purchase.new', 'uses' => 'SiteController@addPurchase']);
Route::get('purchase/all', ['as' => 'purchase.all', 'uses' => 'SiteController@allPurchase']);
Route::get('purchase/list', ['as' => 'purchase.list', 'uses' => 'PurchaseController@getList']);
Route::get('purchase/invoice/{id}', ['as' => 'purchase.invoice.print', 'uses' => 'PurchaseController@getInvoice']);
Route::get('purchase/report', ['as' => 'purchase.report', 'uses' => 'SiteController@purchaseReport']);
Route::get('purchase/report/result', ['as' => 'purchase.report.result', 'uses' => 'PurchaseController@report']);
// Route::get('purchase/edit/{id}', ['as' => 'purchase.edit', 'uses' => 'PurchaseController@editPurchase']);
Route::put('purchase/add', ['as' => 'purchase.add', 'uses' => 'PurchaseController@createPurchase']);
// Route::patch('purchase/{id}', ['as' => 'purchase.update', 'uses' => 'PurchaseController@updatePurchase']);
Route::delete('purchase/{id}', ['as' => 'purchase.delete', 'uses' => 'PurchaseController@deletePurchase']);


// receivable
Route::get('receivable/new', ['as' => 'receivable.new', 'uses' => 'SiteController@addReceivable']);
Route::get('receivable/all', ['as' => 'receivable.all', 'uses' => 'SiteController@allReceivable']);
Route::get('receivable/all-invoice', ['as' => 'receivable.allInvoice', 'uses' => 'SiteController@allReceivableInvoice']);
Route::get('receivable/list', ['as' => 'receivable.list', 'uses' => 'ReceivableController@getList']);
Route::get('receivable/invoice/list', ['as' => 'receivable.invoice.list', 'uses' => 'ReceivableController@getInvoiceList']);
// Route::get('receivable/edit/{id}', ['as' => 'receivable.edit', 'uses' => 'ReceivableController@editReceivable']);
Route::get('receivable/report', ['as' => 'receivable.report', 'uses' => 'SiteController@receivableReport']);
Route::get('receivable/report/result', ['as' => 'receivable.report.result', 'uses' => 'ReceivableController@reportClient']);
Route::get('receivable/invoice-detail/{id}', ['as' => 'receivable.invoice.detail', 'uses' => 'ReceivableController@getInvoiceDetail']);
Route::get('receivable/detail/{id}', ['as' => 'receivable.detail', 'uses' => 'ReceivableController@getDetail']);
Route::put('receivable/add', ['as' => 'receivable.add', 'uses' => 'ReceivableController@createReceivable']);
// Route::patch('receivable/{id}', ['as' => 'receivable.update', 'uses' => 'ReceivableController@updateReceivable']);
Route::delete('receivable/{id}', ['as' => 'receivable.delete', 'uses' => 'ReceivableController@deleteReceivable']);


// debt
Route::get('debt/new', ['as' => 'debt.new', 'uses' => 'SiteController@addDebt']);
Route::get('debt/all', ['as' => 'debt.all', 'uses' => 'SiteController@allDebt']);
Route::get('debt/all-invoice', ['as' => 'debt.allInvoice', 'uses' => 'SiteController@allDebtInvoice']);
Route::get('debt/list', ['as' => 'debt.list', 'uses' => 'DebtController@getList']);
Route::get('debt/invoice/list', ['as' => 'debt.invoice.list', 'uses' => 'DebtController@getInvoiceList']);
Route::get('debt/invoice-detail/{id}', ['as' => 'debt.invoice.detail', 'uses' => 'DebtController@getInvoiceDetail']);
Route::get('debt/detail/{id}', ['as' => 'debt.detail', 'uses' => 'DebtController@getDetail']);
// Route::get('debt/edit/{id}', ['as' => 'debt.edit', 'uses' => 'DebtController@editDebt']);
Route::put('debt/add', ['as' => 'debt.add', 'uses' => 'DebtController@createDebt']);
// Route::patch('debt/{id}', ['as' => 'debt.update', 'uses' => 'DebtController@updateDebt']);
Route::delete('debt/{id}', ['as' => 'debt.delete', 'uses' => 'DebtController@deleteDebt']);


// item
Route::get('item/new', ['as' => 'item.new', 'uses' => 'SiteController@addItem']);
Route::get('item/all', ['as' => 'item.all', 'uses' => 'SiteController@allItem']);
Route::get('item/list', ['as' => 'item.list', 'uses' => 'ItemController@getList']);
Route::get('item/edit/{id}', ['as' => 'item.edit', 'uses' => 'ItemController@editItem']);
Route::get('item/report', ['as' => 'item.report', 'uses' => 'SiteController@itemReport']);
Route::get('item/profit-report', ['as' => 'item.profit.report', 'uses' => 'SiteController@itemReportProfit']);
Route::get('item/profit-report/result', ['as' => 'item.profit.report.result', 'uses' => 'ItemController@reportProfit']);
Route::get('item/purchase-report/result', ['as' => 'item.reportPurchase.result', 'uses' => 'ItemController@reportPurchase']);
Route::get('item/sales-report/result', ['as' => 'item.reportSales.result', 'uses' => 'ItemController@reportSales']);
Route::put('item/add', ['as' => 'item.add', 'uses' => 'ItemController@createItem']);
Route::patch('item/{id}', ['as' => 'item.update', 'uses' => 'ItemController@updateItem']);
Route::delete('item/{id}', ['as' => 'item.delete', 'uses' => 'ItemController@deleteItem']);


// supplier
Route::get('supplier/new', ['as' => 'supplier.new', 'uses' => 'SiteController@addSupplier']);
Route::get('supplier/all', ['as' => 'supplier.all', 'uses' => 'SiteController@allSupplier']);
Route::get('supplier/list', ['as' => 'supplier.list', 'uses' => 'SupplierController@getList']);
Route::get('supplier/edit/{id}', ['as' => 'supplier.edit', 'uses' => 'SupplierController@editSupplier']);
Route::put('supplier/add', ['as' => 'supplier.add', 'uses' => 'SupplierController@createSupplier']);
Route::patch('supplier/{id}', ['as' => 'supplier.update', 'uses' => 'SupplierController@updateSupplier']);
Route::delete('supplier/{id}', ['as' => 'supplier.delete', 'uses' => 'SupplierController@deleteSupplier']);


// client
Route::get('client/new', ['as' => 'client.new', 'uses' => 'SiteController@addClient']);
Route::get('client/all', ['as' => 'client.all', 'uses' => 'SiteController@allClient']);
Route::get('client/regional', ['as' => 'client.regional', 'uses' => 'SiteController@allClientRegional']);
Route::get('client/list', ['as' => 'client.list', 'uses' => 'ClientController@getClientList']);
Route::get('client/regional/list', ['as' => 'client.regional.list', 'uses' => 'ClientController@getRegionList']);
Route::get('client/edit/{id}', ['as' => 'client.edit', 'uses' => 'ClientController@editClient']);
Route::get('client/regional/edit/{id}', ['as' => 'client.regional.edit', 'uses' => 'ClientController@editClientRegional']);
Route::put('client/add', ['as' => 'client.add', 'uses' => 'ClientController@createClient']);
Route::patch('client/{id}', ['as' => 'client.update', 'uses' => 'ClientController@updateClient']);
Route::delete('client/{id}', ['as' => 'client.delete', 'uses' => 'ClientController@deleteClient']);
Route::put('client/regional/add', ['as' => 'client.regional.add', 'uses' => 'ClientController@createRegional']);
Route::patch('client/regional/{id}', ['as' => 'client.regional.update', 'uses' => 'ClientController@updateRegional']);
Route::delete('client/regional/delete/{id}', ['as' => 'client.regional.delete', 'uses' => 'ClientController@deleteRegional']);


// expense
Route::get('expense/new', ['as' => 'expense.new', 'uses' => 'SiteController@addExpense']);
Route::get('expense/all', ['as' => 'expense.all', 'uses' => 'SiteController@allExpense']);
Route::get('expense/list', ['as' => 'expense.list', 'uses' => 'ExpenseController@getList']);
Route::get('expense/edit/{id}', ['as' => 'expense.edit', 'uses' => 'ExpenseController@editExpense']);
Route::get('expense/report', ['as' => 'expense.report', 'uses' => 'SiteController@expenseReport']);
Route::get('expense/report/result', ['as' => 'expense.report.result', 'uses' => 'ExpenseController@report']);
Route::put('expense/add', ['as' => 'expense.add', 'uses' => 'ExpenseController@createExpense']);
Route::patch('expense/{id}', ['as' => 'expense.update', 'uses' => 'ExpenseController@updateExpense']);
Route::delete('expense/{id}', ['as' => 'expense.delete', 'uses' => 'ExpenseController@deleteExpense']);

// user
Route::get('user/new', ['as' => 'user.new', 'uses' => 'SiteController@addUser']);
Route::get('user/all', ['as' => 'user.all', 'uses' => 'SiteController@allUser']);
Route::get('user/list', ['as' => 'user.list', 'uses' => 'UserController@getList']);
Route::get('user/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@editUser']);
Route::put('user/add', ['as' => 'user.add', 'uses' => 'UserController@createUser']);
Route::patch('user/{id}', ['as' => 'user.update', 'uses' => 'UserController@updateUser']);
Route::delete('user/{id}', ['as' => 'user.delete', 'uses' => 'UserController@deleteUser']);
