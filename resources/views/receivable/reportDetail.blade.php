<?php $total = 0; $totalLeft = 0; ?>
@extends('invoice')

@section('title')
Data Piutang PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')
<div>
  <p>Piutang PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}</p>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO.</th>
      <th class="bt">KLIEN</th>
      <th class="bt">TANGGAL DIBUAT</th>
      <th class="bt">JATUH TEMPO</th>
      <th class="bt">INVOICE PENJUALAN</th>
      <th class="bt">JUMLAH</th>
      <th class="bt">SISA</th>
    </tr>
  </thead>

  <tbody>
    @if (count($models) > 0)
    @foreach ($models as $k=>$model)
    <tr>
      <td>{{ $k + 1 }}</td>
      <td>@if ($client = $model->client) <a href="{{ route('client.edit', ['id' => $client->id]) }}" target="_blank">{{ strtoupper($client->client_name) }}</a> @endif</td>
      <td>{{ $model->created_at }}</td>
      <td>{{ $model->due_date }}</td>
      <td>
        <a href="{{ route('sales.invoice.print', ['id' => $model->sales_id]) }}" target="_blank">
          {{ $model->invoice_id }}
        </a>
      </td>
      <td>{{ number_format($model->amount, 0) }}</td>
      <td>{{ number_format($model->amount_left, 0) }}</td>
    </tr>
    <?php $total += $model->amount; $totalLeft += $model->amount_left; ?>
    @endforeach
    @else
    <tr>
      <td colspan="4">Tidak ada data.</td>
    </tr>
    @endif

    <tr>
      <td class="grand total" colspan="5" align="right">
        <strong>TOTAL</strong>
      </td>
      <td class="grand total">
        {{ number_format($total, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($totalLeft, 0) }}
      </td>
    </tr>
  </tbody>
</table>
@stop
