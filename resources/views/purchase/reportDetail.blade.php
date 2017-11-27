<?php $totalGross = 0; $totalDiscount = 0; $totalNet = 0; ?>
@extends('invoice')

@section('title')
Data Pembelian PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')
<div>
  <p>Pembelian PERIODE <strong>{{ \Input::get('month') . '-' . \Input::get('year') }}</strong></p>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO.</th>
      <th class="bt">TANGGAL</th>
      <th class="bt">SUPPLIER</th>
      <th class="bt">INVOICE PEMBELIAN</th>
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
      <td>@if ($supplier = $model->supplier) <a href="{{ route('supplier.edit', ['id' => $supplier->id]) }}" target="_blank">{{ strtoupper($supplier->supplier_name) }}</a> @endif</td>
      <td>
        <a href="{{ route('purchase.invoice.print', ['id' => $model->id]) }}" target="_blank">
          {{ $model->invoice_id }}
        </a>
      </td>
      <td>{{ number_format($model->total_price, 0) }}</td>
      <td>{{ number_format($model->total_discount, 0) }}</td>
      <td>{{ number_format($model->total_final, 0) }}</td>
    </tr>
    <?php $totalGross += $model->total_price; $totalDiscount += $model->total_discount; $totalNet += $model->total_final; ?>
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
