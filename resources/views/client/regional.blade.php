<?php
use App\Repositories\ClientRepository;
$repo = new ClientRepository;
$parentRegion = $repo->findAllRegionParent();
?>

@extends('app')

@section('title')
Regional Klien - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <h2 class="content-heading">Tambah Daerah</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="block">
            <div class="block-header block-header-default">
              <h3 class="block-title">Semua field harus diisi</h3>
              <div class="block-options">
                <a href="{{ route('client.regional.list') }}" title="Semua Klien" class="btn-block-option">
                  <i class="si si-login"></i>
                </a>
              </div>
            </div>

            <div class="block-content">
              <form class="action-form" data-url="{{ route('client.regional.add') }}" http-type="put" id="regionForm">
                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material">
                      <label class="css-control css-control-primary css-switch">
                        <input name="is_parent" type="checkbox" class="css-control-input" checked>
                        <span class="css-control-indicator"></span> Daerah Parent
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="text" class="form-control" id="inputName" name="region_name" required="">
                      <label for="inputName">Nama Daerah</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row" id="parentSelector">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <select class="form-control js-select2" data-placeholder="Choose one.." name="parent_id" >
                        <option value="0">-- Pilih Daerah --</option>
                        @if (count($parentRegion) > 0)
                        @foreach ($parentRegion as $region)
                        <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                        @endforeach
                        @else
                        <option disabled="">-- Tidak ada data daerah --</option>
                        @endif
                      </select>
                      <label for="inputRegion">Parent</label>
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

        <div class="col-md-8">
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
                <a href="{{ route('client.add') }}" title="Tambah Klien" class="btn-block-option">
                  <i class="si si-plus"></i>
                </a>
              </div>
            </div>

            <div class="block-content block-content-full">
              <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-grid" data-url="{{ route('client.regional.list') }}">
                <thead>
                  <tr>
                    <th data-id="created_at">Tanggal Dibuat</th>
                    <th data-id="created_by">Dibuat Oleh</th>
                    <th data-id="region_name">Nama</th>
                    <th data-id="parent_name" data-sortable="false" data-searchable="false">Parent</th>
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
