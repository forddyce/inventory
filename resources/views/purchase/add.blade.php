<?php
  use App\Repositories\SupplierRepository;
  use App\Repositories\ItemRepository;

  $supplierRepo = new SupplierRepository;
  $suppliers = $supplierRepo->findAll();

  $itemRepo = new ItemRepository;
  $items = $itemRepo->findAll();
?>

@extends('app')

@section('title')
Buat Pembelian - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="content">
        <h2 class="content-heading">Tambah Data Pembelian</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="block">
              <div class="block-header block-header-default">
                <h3 class="block-title">Semua field harus diisi</h3>
                <div class="block-options">
                  <a href="#" title="Semua Item" class="btn-block-option">
                    <i class="si si-login"></i>
                  </a>
                </div>
              </div>

              <div class="block-content">
                <form id="purchaseForm" role="form" onsubmit="return false;" data-url="{{ route('purchase.add') }}">
                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="form-control" id="inputInvoice" name="invoice_id" required="">
                        <label for="inputInvoice">Invoice Pembelian</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row" id="supplierContainer">
                    <div class="col-md-9">
                      <div class="form-material">
                        <select class="form-control js-select2" style="width: 100%;" data-placeholder="Choose one.." name="supplier_id" id="inputSupplier">
                          @if (count($suppliers) > 0)
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                            @endforeach
                          @endif
                        </select>
                        <label for="inputSupplier">Supplier</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row" id="supplierContainer">
                    <div class="col-md-9">
                      <div class="form-material">
                        <select class="form-control js-select2" style="width: 100%;" data-placeholder="Choose one.." id="itemList">
                          @if (count($items) > 0)
                            @foreach ($items as $item)
                              <option data-id="{{ $item->id }}" data-name="{{ $item->item_name }}" data-code="{{ $item->item_code }}" data-price="{{ (float) $item->original_price }}" data-last="{{ (float) $item->last_purchase_price }}">{{ $item->item_name }} (Stok: {{ $item->stock . ' ' . $item->item_unit }})</option>
                            @endforeach
                          @endif
                        </select>
                        <label for="itemList">Barang</label>
{{--                         <span class="help-block">
                          <button class="btn btn-info mt-10" id="checkItemBtn">
                            <i class="fa fa-eye m-r-5"></i> Cek Detail Barang
                          </button>
                        </span> --}}
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material">
                        <label class="css-control css-control-primary css-switch">
                          <input id="lastPrice" type="checkbox" class="css-control-input" checked>
                          <span class="css-control-indicator"></span> Pakai harga beli terakhir?
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material input-group">
                        <input type="number" step="any" class="form-control" id="inputItemPrice" required="">
                        <label for="inputItemPrice">Harga Per Unit</label>
                        <span class="input-group-addon">IDR</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating input-group">
                        <input type="number" step="any" class="form-control" value="1" min="1" id="inputItemQuantity">
                        <label for="inputItemQuantity">Kuantitas</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating input-group">
                        <select class="form-control" id="discountType">
                          <option value="none">-- Tidak Ada Diskon --</option>
                          <option value="nominal">Nominal</option>
                          <option value="percent">Persen</option>
                        </select>
                        <label for="discountType">Tipe Diskon</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row" id="discountNominalContainer">
                    <div class="col-md-9">
                      <div class="form-material floating input-group">
                        <input type="number" step="any" class="form-control" id="inputDiscountNominal">
                        <label for="inputDiscountNominal">Total Diskon Nominal</label>
                        <span class="input-group-addon">IDR</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row" id="discountPercentContainer">
                    <div class="col-md-9">
                      <div class="form-material floating input-group">
                        <input type="number" step="any" class="form-control" id="inputDiscountPercent" min="0.1" max="99.9">
                        <label for="inputDiscountPercent">Total Diskon Persen</label>
                        <span class="input-group-addon">%</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <button type="button" class="btn btn-block btn-hero btn-noborder btn-info" data-toggle="click-ripple" id="addItemBtn">
                        Tambah ITEM
                      </button>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material">
                        <label class="css-control css-control-primary css-switch">
                          <input id="hasComplete" name="is_complete" type="checkbox" class="css-control-input" checked>
                          <span class="css-control-indicator"></span> Sudah Lunas?
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row debt-container">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="number" name="debt_amount" class="form-control" value="0" min="0">
                        <label for="inputDate">Jumlah Hutang</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row debt-container">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="js-datepicker form-control" name="paid_date" required="" id="inputDate" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd">
                        <label for="inputDate">Tanggal Pembayaran</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <button type="button" class="ladda-button btn btn-block btn-hero btn-noborder btn-success mt-30" data-style="expand-left" data-toggle="click-ripple" id="submitBtn">
                        Submit DATA PEMBELIAN
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="block">
              <div class="block-header block-header-default">
                <h3 class="block-title">Data Pembelian</h3>
              </div>
              <div class="block-content">
                <div class="table-responsive">
                  <table class="table table-hover table-striped table-bordered" id="itemTableData">
                    <thead>
                      <tr class="table-warning">
                        <th>Nama Item</th>
                        <th>Kode Unik</th>
                        <th>Kuantitas</th>
                        <th>Harga Awal</th>
                        <th>Diskon</th>
                        <th>Sub Total</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <tr class="table-success">
                        <th colspan="4">
                          <h3>TOTAL</h3>
                        </th>
                        <th colspan="3">
                          <h2 id="totalLabel"></h2>
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    @include('include.footer')
  </div>
@stop
