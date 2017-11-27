<?php $total = 0; ?>
@extends('invoice')

@section('title')
Data Biaya PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')
<div>
  <p>Biaya PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}</p>
</div>

<table>
  <thead>
    <tr>
      <th class="bt">NO</th>
      <th class="bt">TANGGAL</th>
      <th class="bt">BIAYA</th>
      <th class="bt">KETERANGAN</th>
      <th class="bt">JUMLAH</th>
    </tr>
  </thead>

  <tbody>
    @if (count($models) > 0)
    @foreach ($models as $k=>$model)
    <tr>
      <td>{{ $k + 1 }}</td>
      <td>{{ $model->created_at }}</td>
      <td>{{ $model->expense_name }}</td>
      <td>{{ $model->expense_notes }}</td>
      <td>{{ number_format($model->amount, 0) }}</td>
    </tr>
    <?php $total += $model->amount; ?>
    @endforeach
    @else
    <tr>
      <td colspan="4">Tidak ada data.</td>
    </tr>
    @endif

    <tr>
      <td class="grand total" colspan="4" align="right">
        <strong>TOTAL</strong>
      </td>
      <td class="grand total">
        {{ number_format($total, 0) }}
      </td>
    </tr>
  </tbody>
</table>
@stop
