<?php
  use App\Repositories\ClientRepository;
  $repo = new ClientRepository;
  $parentRegion = $repo->findAllRegionParent();
?>

@extends('app')

@section('title')
Tambah Klien - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="content">
        <h2 class="content-heading">Tambah Klien</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="block">
              <div class="block-header block-header-default">
                <h3 class="block-title">Semua field harus diisi</h3>
                <div class="block-options">
                  <a href="{{ route('client.all') }}" title="Semua Klien" class="btn-block-option">
                    <i class="si si-login"></i>
                  </a>
                </div>
              </div>

              <div class="block-content">
                <form class="action-form" data-url="{{ route('client.add') }}" http-type="put">
                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="form-control" id="inputName" name="client_name" required="">
                        <label for="inputName">Nama Klien</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <select class="form-control js-select2" data-placeholder="Choose one.." name="region_id" id="inputRegion">
                          @if (count($parentRegion) > 0)
                            @foreach ($parentRegion as $region)
                              <optgroup label="{{ $region->region_name }}">
                                <?php $childrenRegion = $region->childrenRegion(); ?>
                                @if (count($childrenRegion) > 0)
                                  @foreach ($childrenRegion as $child)
                                    <option value="{{ $child->id }}">{{ $child->region_name }}</option>
                                  @endforeach
                                @else
                                  <option disabled="">-- Tidak ada data daerah dalam {{ $region->region_name }} --</option>
                                @endif
                              </optgroup>
                            @endforeach
                          @else
                            <option disabled="">-- Tidak ada data daerah --</option>
                          @endif
                        </select>
                        <label for="inputRegion">Daerah</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="form-control" id="inputPhone" name="client_phone">
                        <label for="inputAddress">Nomor Telp</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <textarea class="form-control" id="inputAddress" name="client_address" maxlength="2500"></textarea>
                        <label for="inputAddress">Alamat</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <textarea class="form-control" id="inputNotes" name="client_notes" maxlength="2500"></textarea>
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
