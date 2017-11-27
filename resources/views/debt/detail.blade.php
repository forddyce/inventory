@extends('app')

@section('title')
Data Hutang - {{ config('app.name') }}
@stop

@section('content')
<div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
  @include('include.header')
  @include('include.sidebar')

  <main id="main-container">
    <div class="content">
      <h2 class="content-heading">Data Hutang</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="block">
            <div class="block-header block-header-default">
              <h3>Data Hutang #{{ $model->id }}</h3>
            </div>

            <div class="block-content block-content-full">
              <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <tbody>
                    <tr>
                      <td>Invoice Pembelian</td>
                      <td>:</td>
                      <td>
                        @if ($purchase = $model->purchase)
                          <a href="{{ route('purchase.invoice.print', ['id' => $purchase->id]) }}" target="_blank">
                            {{ $purchase->invoice_id }}
                          </a>
                        @else
                          {{ $model->invoice_id }}
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td>Jumlah</td>
                      <td>:</td>
                      <td><strong>{{ number_format($model->amount, 0) }}</strong></td>
                    </tr>

                    <tr>
                      <td>Sisa</td>
                      <td>:</td>
                      <td><strong>{{ number_format($model->amount_left, 0) }}</strong></td>
                    </tr>

                    <tr>
                      <td>Tanggal Pembayaran</td>
                      <td>:</td>
                      <td>{{ $model->due_date->format('d F Y') }}</td>
                    </tr>

                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td>
                        @if ($model->is_complete)
                          <span class="badge badge-success">SELESAI</span>
                        @else
                          <span class="badge badge-danger">BELUM SELESAI</span>
                        @endif
                      </td>
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
