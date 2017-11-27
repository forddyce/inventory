<?php
  use App\Repositories\DebtRepository;
  use App\Repositories\ReceivableRepository;
  $debtRepo = new DebtRepository;
  $receivableRepo = new ReceivableRepository;
?>

@extends('app')

@section('title')
Home - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <div class="content">
        <div class="row gutters-tiny invisible" data-toggle="appear">
          <div class="col-6 col-xl-4">
            <a class="block block-transparent text-center bg-gd-lake" href="{{ route('receivable.all') }}">
              <div class="block-content">
                <p class="font-size-h1 text-white">
                  <strong data-toggle="countTo" data-speed="1000" data-to="{{ $receivableRepo->findDue() }}">0</strong>
                </p>
                <p class="font-w600 text-white-op">
                  <i class="si si-action-undo mr-5"></i> Piutang Dalam 7 Hari
                </p>
              </div>
            </a>
          </div>
          <div class="col-6 col-xl-4">
            <a class="block block-transparent text-center bg-danger" href="{{ route('debt.all') }}">
              <div class="block-content">
                <p class="font-size-h1 text-white">
                  <strong data-toggle="countTo" data-speed="1000" data-to="{{ $debtRepo->findDue() }}">0</strong>
                </p>
                <p class="font-w600 text-white-op">
                  <i class="si si-action-redo mr-5"></i> Hutang Dalam 7 Hari
                </p>
              </div>
            </a>
          </div>
        </div>

        <div class="row gutters-tiny invisible" data-toggle="appear">
          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-corporate" href="{{ route('sales.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-basket fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">BUAT PENJUALAN</p>
            </div>
            </a>
          </div>

          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-gd-sun" href="{{ route('purchase.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-basket-loaded fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">BUAT PEMBELIAN</p>
            </div>
            </a>
          </div>

          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-elegance" href="{{ route('receivable.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-action-redo fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">BUAT PELUNASAN PIUTANG</p>
            </div>
            </a>
          </div>

          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-success" href="{{ route('debt.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-action-undo fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">BUAT PELUNASAN HUTANG</p>
            </div>
            </a>
          </div>
        </div>

        <div class="row gutters-tiny invisible" data-toggle="appear">
          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-success" href="{{ route('supplier.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-people fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">TAMBAH SUPPLIER</p>
            </div>
            </a>
          </div>

          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-gd-dusk" href="{{ route('client.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si si-emotsmile fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">TAMBAH KLIEN</p>
            </div>
            </a>
          </div>

          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-info" href="{{ route('item.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-bag fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">TAMBAH ITEM</p>
            </div>
            </a>
          </div>

          <div class="col-6 col-xl-3">
            <a class="block block-transparent text-center bg-black" href="{{ route('expense.new') }}">
            <div class="block-content">
              <p class="mt-5">
                <i class="si si-diamond fa-4x text-white-op"></i>
              </p>
              <p class="font-w600 text-white">TAMBAH BIAYA</p>
            </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('include.footer')
</div>
@stop
