@extends('app')

@section('title')
Semua Supplier - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="block">
            <div class="block-header block-header-default">
              <div class="form-group row">
                <label class="col-12" for="example-daterange1">Tanggal</label>
                <div class="col-lg-8">
                  <div class="input-daterange input-group" id="tableDateRange" data-date-format="yyyy-mm-dd" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    <input type="text" class="form-control" name="date_from" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    <span class="input-group-addon font-w600">to</span>
                    <input type="text" class="form-control" name="date_to" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                  </div>
                </div>

                <div class="col-lg-4">
                  <button type="button" id="dateSearch" class="btn btn-primary" data-toggle="click-ripple">Cari</button>
                </div>
              </div>

              <div class="block-options">
                <a href="{{ route('supplier.new') }}" title="Tambah Supplier" class="btn-block-option">
                  <i class="si si-plus"></i>
                </a>
              </div>
            </div>

            <div class="block-content block-content-full">
              <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-grid" data-url="{{ route('supplier.list') }}">
                <thead>
                  <tr>
                    <th data-id="created_at">Tanggal Dibuat</th>
                    <th data-id="created_by">Dibuat Oleh</th>
                    <th data-id="supplier_name">Nama</th>
                    <th data-id="supplier_phone">Telepon</th>
                    <th data-id="action" data-sortable="false" data-searchable="false"></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('include.footer')
</div>
@stop
