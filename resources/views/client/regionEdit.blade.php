<?php
use App\Repositories\ClientRepository;
$repo = new ClientRepository;
$parentRegion = $repo->findAllRegionParent();
?>

@extends('app')

@section('title')
Edit {{ $model->region_name }} - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <h2 class="content-heading">Edit {{ $model->region_name }}</h2>
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
              <form class="action-form" data-url="{{ route('client.regional.update', ['id' => $model->id]) }}" http-type="patch" id="regionForm">
                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material">
                      <label class="css-control css-control-primary css-switch">
                        <input name="is_parent" type="checkbox" class="css-control-input" @if ($model->is_parent) checked="" @endif>
                        <span class="css-control-indicator"></span> Daerah Parent
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="text" class="form-control" id="inputName" name="region_name" required="" value="{{ $model->region_name }}">
                      <label for="inputName">Nama Daerah</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row" id="parentSelector">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <select class="form-control js-select2" data-placeholder="Choose one.." name="parent_id">
                        <option value="0" @if ($model->parent_id == '0') selected="" @endif>-- Pilih Daerah --</option>
                        @if (count($parentRegion) > 0)
                        @foreach ($parentRegion as $region)
                        <option value="{{ $region->id }}" @if ($model->parent_id == $region->id) selected="" @endif>{{ $region->region_name }}</option>
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
      </div>
    </div>
  </main>
  @include('include.footer')
</div>
@stop
