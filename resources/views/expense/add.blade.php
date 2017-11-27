@extends('app')

@section('title')
Tambah Biaya - {{ config('app.name') }}
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
                <a href="{{ route('expense.all') }}" title="Semua Biaya" class="btn-block-option">
                  <i class="si si-login"></i>
                </a>
              </div>
            </div>

            <div class="block-content">
              <form class="action-form" data-url="{{ route('expense.add') }}" http-type="put">
                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="text" class="form-control" id="inputName" name="expense_name" required="">
                      <label for="inputName">Nama</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <textarea class="form-control" name="expense_notes" id="inputNotes"></textarea>
                      <label for="inputNotes">Keterangan</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material floating">
                      <input type="number" min="100" required="" value="0" class="form-control" id="inputAmount" name="amount">
                      <label for="inputAmount">Jumlah</label>
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
