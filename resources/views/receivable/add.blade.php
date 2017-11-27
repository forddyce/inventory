<?php
use App\Repositories\ClientRepository;
$clientRepo = new ClientRepository;
$clients = $clientRepo->findAll();
?>

@extends('app')

@section('title')
Buat Piutang - {{ config('app.name') }}
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
                <a href="{{ route('receivable.all') }}" title="Semua Hutang" class="btn-block-option">
                  <i class="si si-login"></i>
                </a>
              </div>
            </div>

            <div class="block-content">
              <form class="action-form" id="receivableForm" data-url="{{ route('receivable.add') }}" http-type="put">
                <div class="form-group row">
                  <div class="col-md-9">
                    <div class="form-material">
                      <label class="css-control css-control-primary css-switch">
                        <input name="is_client" type="checkbox" class="css-control-input" checked>
                        <span class="css-control-indicator"></span> Pelunasan Piutang Klien?
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

                <div class="form-group row" id="clientContainer">
                  <div class="col-md-9">
                    <div class="form-material">
                      <select class="form-control js-select2" style="width: 100%;" data-placeholder="Choose one.." name="client_id" id="inputClient">
                        @if (count($clients) > 0)
                        @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                        @endforeach
                        @endif
                      </select>
                      <label for="inputClient">Klien</label>
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
