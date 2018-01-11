<?php
use App\Repositories\ItemRepository;
$itemRepo = new ItemRepository;
$items = $itemRepo->findAll();
?>

@extends('app')

@section('title')
Laporan Histori Per Item - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="content">
        <h2 class="content-heading">Laporan Histori Per Item</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="block">
              <div class="block-header block-header-default">
                <h5><span class="si si-clock"></span> PEMBELIAN PERIODE</h5>
              </div>
              <div class="block-content block-content-full">
                <form target="_blank" action="{{ route('item.reportPurchase.result') }}">
                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material">
                        <select class="form-control js-select2" style="width: 100%;" data-placeholder="Choose one.." name="item_id" id="inputItemPurchase">
                          <option value="0">-- Semua Item --</option>
                          @if (count($items) > 0)
                          @foreach ($items as $item)
                          <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                          @endforeach
                          @endif
                        </select>
                        <label for="inputItemPurchase">Item</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <select class="form-control" name="month">
                          @for ($i = 1; $i <= 12; $i++)
                            <?php if ($i<10) $i = '0' . $i; ?>
                            <option value="{{ $i }}" @if (date('m') == $i) selected="" @endif>{{ $i }}</option>
                          @endfor
                        </select>
                        <label for="inputName">Bulan</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <?php $currentYear = date('Y'); ?>
                        <select class="form-control" name="year">
                          <option value="{{ $currentYear }}" selected="">{{ $currentYear }}</option>
                          @for ($i = 1; $i < 5; $i++)
                            <option value="{{ $currentYear - $i }}">{{ $currentYear - $i }}</option>
                          @endfor
                        </select>
                        <label for="inputName">Tahun</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <button type="submit" class="ladda-button btn btn-block btn-hero btn-noborder btn-primary" data-style="expand-left" data-toggle="click-ripple">
                        <i class="fa fa-search m-r-5"></i> Cari
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
                <h5><span class="si si-clock"></span> PENJUALAN PERIODE</h5>
              </div>
              <div class="block-content block-content-full">
                <form target="_blank" action="{{ route('item.reportSales.result') }}">
                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material">
                        <select class="form-control js-select2" style="width: 100%;" data-placeholder="Choose one.." name="item_id" id="inputItemSales">
                          <option value="0">-- Semua Item --</option>
                          @if (count($items) > 0)
                          @foreach ($items as $item)
                          <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                          @endforeach
                          @endif
                        </select>
                        <label for="inputItemSales">Item</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <select class="form-control" name="month">
                          @for ($i = 1; $i <= 12; $i++)
                            <?php if ($i<10) $i = '0' . $i; ?>
                            <option value="{{ $i }}" @if (date('m') == $i) selected="" @endif>{{ $i }}</option>
                          @endfor
                        </select>
                        <label for="inputName">Bulan</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <?php $currentYear = date('Y'); ?>
                        <select class="form-control" name="year">
                          <option value="{{ $currentYear }}" selected="">{{ $currentYear }}</option>
                          @for ($i = 1; $i < 5; $i++)
                            <option value="{{ $currentYear - $i }}">{{ $currentYear - $i }}</option>
                          @endfor
                        </select>
                        <label for="inputName">Tahun</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <button type="submit" class="ladda-button btn btn-block btn-hero btn-noborder btn-primary" data-style="expand-left" data-toggle="click-ripple">
                        <i class="fa fa-search m-r-5"></i> Cari
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
