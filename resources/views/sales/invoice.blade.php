@extends('invoice')

@section('title')
Penjualan #{{ $model->id }}
@stop

@section('content')
<div>
  <p>INVOICE #{{ $model->invoice_id }}</p>
  <div id="company">
    <div>PT. TEST</div>
    <div>Jl. TEST, Sumatera Utara, Medan</div>
    <div>(081) xxx-xxxx</div>
    <div><strong>BRI - 000000000000 A/N MYSELF</strong></div>
    <div><strong>BCA - 0000000000 A/N MYSELF</strong></div>
  </div>
  <div id="project">
    @if ($client = $model->client)
      <div><span>KLIEN:</span> {{ strtoupper($client->client_name) }} </div>
      <div><span>ALAMAT:</span> {{ strtoupper($client->client_address) }}</div>
    @endif
    <div><span>TANGGAL:</span> {{ $model->created_at->format('d F, Y') }}</div>
    @if (!$model->is_complete)
      @if ($receivable = $model->receivable)
        <div><span>JATUH TEMPO: </span> {{ $receivable->due_date->format('d F, Y') }}</div>
      @endif
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
    <?php $sales = json_decode($model->sales_info, 1); $total = 0; ?>
    @if (count($sales) > 0)
    @foreach ($sales as $k => $sales)
    <tr>
      <td>{{ $k + 1 }}</td>
      <td>{{ $sales['item_name'] }}</td>
      <td>{{ $sales['quantity'] . ' ' . strtoupper($sales['item_unit']) }}</td>
      <td>{{ number_format($sales['price'], 0) }}</td>
      <td>{{ number_format($sales['discount'], 0) }}</td>
      <td>{{ number_format($sales['total'], 0) }}</td>
    </tr>
    <?php $total += $sales['total']; ?>
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

<table border="1" class="info">
  <thead>
    <tr>
      <th align="center">TANDA TERIMA:</th>
      <th align="center">DICETAK OLEH:</th>
      <th align="center">CHECK BARANG:</th>
      <th align="center">SUPIR:</th>
    </tr>
  </thead>

{{--   <tbody>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody> --}}
</table>

@stop
