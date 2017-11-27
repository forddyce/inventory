<?php 
  $totalGross = 0;
  $totalDiscount = 0;
  $totalNet = 0;
?>

@extends('invoice')

@section('title')
Pembelian item PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')
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
    @if (count($models) > 0)
    @foreach ($models as $k=>$model)
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
      $totalGross += $model->price;
      $totalDiscount += $model->discount;
      $totalNet += $model->total;
    ?>
    @endforeach
    @else
    <tr>
      <td colspan="9">Tidak ada data.</td>
    </tr>
    @endif

    <tr>
      <td class="grand total" colspan="6" align="right">
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
