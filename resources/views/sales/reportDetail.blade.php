<?php $totalGross = 0; $totalDiscount = 0; $totalNet = 0; ?>
@extends('invoice')

@section('title')
Data Penjualan PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')
<div>
  <p>Penjualan PERIODE <strong>{{ \Input::get('month') . '-' . \Input::get('year') }}</strong></p>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO.</th>
      <th class="bt">TANGGAL</th>
      <th class="bt">KLIEN</th>
      <th class="bt">INVOICE PENJUALAN</th>
      <th class="bt">HARGA</th>
      <th class="bt">DISKON</th>
      <th class="bt">TOTAL</th>
    </tr>
  </thead>

  <tbody>
    @if (count($models) > 0)
    @foreach ($models as $k=>$model)
    <tr>
      <td>{{ $k + 1 }}</td>
      <td>{{ $model->created_at }}</td>
      <td>@if ($client = $model->client) <a href="{{ route('client.edit', ['id' => $client->id]) }}" target="_blank">{{ strtoupper($client->client_name) }}</a> @endif</td>
      <td>
        <a href="{{ route('sales.invoice.print', ['id' => $model->id]) }}" target="_blank">
          {{ $model->invoice_id }}
        </a>
      </td>
      <td>{{ number_format($model->total_gross, 0) }}</td>
      <td>{{ number_format($model->total_discount, 0) }}</td>
      <td>{{ number_format($model->total_net, 0) }}</td>
    </tr>
    <?php $totalGross += $model->total_gross; $totalDiscount += $model->total_discount; $totalNet += $model->total_net; ?>
    @endforeach
    @else
    <tr>
      <td colspan="7">Tidak ada data.</td>
    </tr>
    @endif

    <tr>
      <td class="grand total" colspan="4" align="right">
        <strong>TOTAL</strong>
      </td>
      <td class="grand total">
        {{ number_format($totalGross, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($totalDiscount, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($totalNet, 0) }}
      </td>
    </tr>
  </tbody>
</table>
@stop
