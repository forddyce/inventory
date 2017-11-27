<?php
  use App\Repositories\ReceivableRepository;
  $receivableRepo = new ReceivableRepository;
?>

@extends('app')

@section('title')
Pelunasan Piutang #{{ $model->id }} - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <h2 class="content-heading">Data Pelunasan Piutang</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="block">
            <div class="block-header block-header-default">
              <h3>Pelunasan Piutang #{{ $model->id }}</h3>
            </div>

            <div class="block-content block-content-full">
              <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr class="table-success">
                      <th>Invoice</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <?php $invoices = json_decode($model->receivable_infos, 1); $total = 0; ?>
                  <tbody>
                    @if (count($invoices) > 0)
                      @foreach ($invoices as $invoice)
                      <?php
                        $link = '#';
                        if ($receivable = $receivableRepo->findById($invoice['receivable_id'])) {
                          if ($sales = $receivable->sales) {
                            $link = route('sales.invoice.print', ['id' => $sales->id]);
                          }
                        }
                      ?>
                      <tr>
                        <td>
                          <a href="{{ $link }}" target="_blank">
                            {{ $invoice['invoice_id'] }}
                          </a>
                        </td>
                        <td>{{ number_format($invoice['amount'], 0) }}</td>
                      </tr>
                      <?php $total += $invoice['amount']; ?>
                      @endforeach
                    @else
                    <tr>
                      <td colspan="2">Tidak ada data invoice</td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr class="table-warning">
                      <th>TOTAL</th>
                      <th><strong>{{ number_format($total, 0) }}</strong></th>
                    </tr>
                  </tfoot>
                </table>

                <table class="table table-striped table-bordered">
                  <thead>
                    <tr class="table-info">
                      <th>Keterangan</th>
                      <th>Catatan</th>
                      <th>Tanggal Pembayaran</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td>{{ $model->other_title }}</td>
                      <td>{{ $model->other_notes }}</td>
                      <td>{{ $model->paid_date->format('d F Y') }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('include.footer')
</div>
@stop
