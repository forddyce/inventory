@extends('app')

@section('title')
Edit {{ $model->item_name }} - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="content">
        <h2 class="content-heading">Edit {{ $model->item_name }}</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="block">
              <div class="block-header block-header-default">
                <h3 class="block-title">Semua field harus diisi</h3>
                <div class="block-options">
                  <a href="{{ route('item.all') }}" title="Semua Item" class="btn-block-option">
                    <i class="si si-login"></i>
                  </a>
                </div>
              </div>

              <div class="block-content">
                <form class="action-form" data-url="{{ route('item.update', ['id' => $model->id]) }}" http-type="patch">
                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="form-control" id="inputItemName" name="item_name" required="" value="{{ $model->item_name }}">
                        <label for="inputItemName">Nama Item</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="form-control" id="inputItemCode" name="item_code" required="" value="{{ $model->item_code }}">
                        <label for="inputItemCode">Kode Unik Item</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="text" class="form-control" id="inputItemUnit" name="item_unit" required="" value="{{ $model->item_unit }}">
                        <label for="inputItemUnit">Satuan Unit</label>
                        <div class="form-text text-muted text-right">ex. PCS / BOX</div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating input-group">
                        <input type="number" step="any" class="form-control" id="inputItemPrice" name="original_price" required="" value="{{ (float) $model->original_price }}">
                        <label for="inputItemPrice">Harga Per Unit</label>
                        <span class="input-group-addon">IDR</span>
                      </div>
                    </div>
                  </div>

                  {{-- <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material floating">
                        <input type="number" step="any" class="form-control" id="inputItemStock" name="stock" required="" value="{{ $model->stock }}" min="0">
                        <label for="inputItemStock">Stok</label>
                      </div>
                    </div>
                  </div> --}}

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
