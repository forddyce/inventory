<?php
use App\Repositories\SupplierRepository;
$supplierRepo = new SupplierRepository;
$suppliers = $supplierRepo->findAll();
?>

@extends('app')

@section('title')
Buat Pelunasan Hutang - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="block">
            <div class="block-header block-header-default">
              <h3 class="block-title">Semua field harus diisi</h3>
              <div class="block-options">
                <a href="{{ route('debt.all') }}" title="Semua Hutang" class="btn-block-option">
                  <i class="si si-login"></i>
                </a>
              </div>
            </div>

            <div class="block-content">
              <form class="action-form" id="debtForm" data-url="{{ route('debt.add') }}" http-type="put">
                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material">
                      <label class="css-control css-control-primary css-switch">
                        <input name="is_supplier" type="checkbox" class="css-control-input" checked>
                        <span class="css-control-indicator"></span> Pelunasan Hutang Supplier?
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group row" id="otherContainer">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="text" class="form-control" id="inputOtherTitle" name="other_title">
                      <label for="inputOtherTitle">Digunakan Untuk</label>
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

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="number" min="1000" required="" value="0" class="form-control" id="inputAmount" name="amount">
                      <label for="inputAmount">Jumlah</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="text" class="js-datepicker form-control" name="paid_date" required="" id="inputDate" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd">
                      <label for="inputDate">Tanggal Pembayaran</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <textarea class="form-control" id="inputNotes" name="other_notes" maxlength="2500"></textarea>
                      <label for="inputNotes">Catatan</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <button type="submit" class="ladda-button btn btn-block btn-hero btn-noborder btn-success" data-style="expand-left" data-toggle="click-ripple">
                      Submit
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('include.footer')
</div>
@stop
