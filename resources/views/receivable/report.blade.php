<?php
use App\Repositories\ClientRepository;
$clientRepo = new ClientRepository;
$clients = $clientRepo->findAll();
?>

@extends('app')

@section('title')
Laporan Piutang Klien - {{ config('app.name') }}
@stop

@section('content')
  <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
    @include('include.header')
    @include('include.sidebar')

    <main id="main-container">
      <div class="content">
        <h2 class="content-heading">Laporan Piutang Klien</h2>
        <div class="row">
          <div class="col-md-8">
            <div class="block">
              <div class="block-header block-header-default">
                <h5><span class="si si-clock"></span> PERIODE</h5>
              </div>
              <div class="block-content block-content-full">
                <form target="_blank" action="{{ route('receivable.report.result') }}">
                  <div class="form-group row">
                    <div class="col-md-9">
                      <div class="form-material">
                        <select class="form-control js-select2" style="width: 100%;" data-placeholder="Choose one.." name="client_id" id="inputClient">
                          <option value="0">-- Semua Klien --</option>
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
