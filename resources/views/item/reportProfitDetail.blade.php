<?php 
  $purchaseGross = 0;
  $purchaseDiscount = 0;
  $purchaseNet = 0;

  $salesGross = 0;
  $salesDiscount = 0;
  $salesNet = 0;
?>

@extends('invoice')

@section('title')
Laporan Item PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')
<!-- PURCHASE -->
<div>
  <p>Pembelian Item PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}</p>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO</th>
      <th class="bt">TANGGAL</th>
      <th class="bt">NAMA ITEM</th>
      <th class="bt">INVOICE</th>
      <th class="bt">QTY</th>
      <th class="bt">HARGA SATUAN</th>
      <th class="bt">HARGA</th>
      <th class="bt">DISKON</th>
      <th class="bt">TOTAL</th>
    </tr>
  </thead>

  <tbody>
    @if (count($data['purchase']) > 0)
    @foreach ($data['purchase'] as $k=>$model)
    <?php $item = $model->item; ?>
    <tr>
      <td>{{ $k + 1 }}</td>
      <td>{{ $model->created_at }}</td>
      <td>
        @if ($item)
          {{ $item->item_name }}
        @endif
      </td>
      <td><a href="{{ route('purchase.invoice.print', ['id' => $model->purchase_id]) }}" target="_blank">{{ $model->invoice_id }}</a></td>
      @if ($item)
        <td>{{ $model->quantity . ' ' . $item->item_unit }}</td>
      @else
        <td>{{ $model->quantity }}</td>
      @endif
      <td>{{ number_format($model->unit_price, 0) }}</td>
      <td>{{ number_format($model->price, 0) }}</td>
      <td>{{ number_format($model->discount, 0) }}</td>
      <td>{{ number_format($model->total, 0) }}</td>
    </tr>
    <?php 
      $purchaseGross += $model->price;
      $purchaseDiscount += $model->discount;
      $purchaseNet += $model->total;
    ?>
    @endforeach
    @else
    <tr>
      <td colspan="9">Tidak ada data.</td>
    </tr>
    @endif
  </tbody>
</table>
<!-- END PURCHASE -->
<hr>

<!-- SALES -->
<div>
  <p>Penjualan Item PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}</p>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO</th>
      <th class="bt">TANGGAL</th>
      <th class="bt">NAMA ITEM</th>
      <th class="bt">INVOICE</th>
      <th class="bt">QTY</th>
      <th class="bt">HARGA SATUAN</th>
      <th class="bt">HARGA</th>
      <th class="bt">DISKON</th>
      <th class="bt">TOTAL</th>
    </tr>
  </thead>

  <tbody>
    @if (count($data['sales']) > 0)
    @foreach ($data['sales'] as $k=>$model)
    <?php $item = $model->item; ?>
    <tr>
      <td>{{ $k + 1 }}</td>
      <td>{{ $model->created_at }}</td>
      <td>
        @if ($item)
          {{ $item->item_name }}
        @endif
      </td>
      <td><a href="{{ route('sales.invoice.print', ['id' => $model->sales_id]) }}" target="_blank">{{ $model->invoice_id }}</a></td>
      @if ($item)
        <td>{{ $model->quantity . ' ' . $item->item_unit }}</td>
      @else
        <td>{{ $model->quantity }}</td>
      @endif
      <td>{{ number_format($model->unit_price, 0) }}</td>
      <td>{{ number_format($model->price, 0) }}</td>
      <td>{{ number_format($model->discount, 0) }}</td>
      <td>{{ number_format($model->total, 0) }}</td>
    </tr>
    <?php 
      $salesGross += $model->price;
      $salesDiscount += $model->discount;
      $salesNet += $model->total;
    ?>
    @endforeach
    @else
    <tr>
      <td colspan="9">Tidak ada data.</td>
    </tr>
    @endif
  </tbody>
</table>

<!-- END SALES -->

<hr>

<!-- SUMMARY -->

<table>
  <thead>
    <tr>
      <th></th>
      <th>TOTAL</th>
      <th>DISKON</th>
      <th>TOTAL NET</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td class="grand total" align="right">
        <strong>PENJUALAN</strong>
      </td>
      <td class="grand total">
        {{ number_format($salesGross, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($salesDiscount, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($salesNet, 0) }}
      </td>
    </tr>

    <tr>
      <td class="grand total" align="right">
        <strong>PEMBELIAN</strong>
      </td>
      <td class="grand total">
        {{ number_format($purchaseGross, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($purchaseDiscount, 0) }}
      </td>
      <td class="grand total">
        {{ number_format($purchaseNet, 0) }}
      </td>
    </tr>

    <?php
      $isProfit = true;
      if ($purchaseNet > $salesNet) $isProfit = false;
    ?>

    <tr @if ($isProfit) style="color:green;" @else style="color:red;" @endif>
      <td class="grand total" colspan="3" align="right">
        <strong>@if (!$isProfit) RUGI @else LABA @endif</strong>
      </td>
      <td class="grand total">
        @if ($isProfit) + @else - @endif{{ number_format(abs($purchaseNet - $salesNet), 0) }}
      </td>
    </tr>
  </tbody>
</table>
<!-- END SUMMARY -->
@stop
