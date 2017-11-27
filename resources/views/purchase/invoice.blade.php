@extends('invoice')

@section('title')
Pembelian #{{ $model->id }}
@stop

@section('content')
<div>
  <p>iNVOICE #{{ $model->invoice_id }}</p>
  <div id="company">
    <div>PT. TEST</div>
    <div>Jl. TEST <br /> Sumatera Utara, Medan</div>
    <div>(081) xxx-xxxx</div>
  </div>
  <div id="project">
    <div><span>TANGGAL</span> {{ $model->created_at->format('d F, Y') }}</div>
    @if ($debt = $model->debt)
      <div><span>HUTANG:</span> {{ number_format($debt->amount, 0) }}</div>
      <div><span>SISA:</span> {{ number_format($debt->amount_left, 0) }}</div>
      <div><span>JATUH TEMPO: </span> {{ $debt->due_date->format('d F, Y') }}</div>
    @endif
  </div>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO</th>
      <th class="bt">ITEM</th>
      <th class="bt">QTY</th>
      <th class="bt">HARGA SATUAN</th>
      <th class="bt">DISKON</th>
      <th class="bt">TOTAL</th>
    </tr>
  </thead>

  <tbody>
    <?php $purchases = json_decode($model->purchase_info, 1); $total = 0; ?>
    @if (count($purchases) > 0)
      @foreach ($purchases as $k => $purchase)
      <tr>
        <td>{{ $k + 1 }}</td>
        <td>{{ $purchase['item_name'] }}</td>
        <td>{{ $purchase['quantity'] . ' ' . strtoupper($purchase['item_unit']) }}</td>
        <td>{{ number_format($purchase['price'], 0) }}</td>
        <td>{{ number_format($purchase['discount'], 0) }}</td>
        <td>{{ number_format($purchase['total'], 0) }}</td>
      </tr>
      <?php $total += $purchase['total']; ?>
      @endforeach
    @endif

    <tr>
      <td class="grand total" colspan="5" align="right">TOTAL</td>
      <td class="grand total">
        {{ number_format($total, 0) }}
      </td>
    </tr>
  </tbody>
</table>

@stop
