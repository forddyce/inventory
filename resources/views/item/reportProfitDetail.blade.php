<?php $grandTotal = 0; ?>
@extends('invoice')

@section('title')
Laporan Item PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}
@stop

@section('content')

<!-- SALES -->
<div>
  <p>Penjualan Item PERIODE {{ \Input::get('month') . '-' . \Input::get('year') }}</p>
</div>

<table>
  <thead>
    <tr class="blue">
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
        <tr class="blue">
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

        <tr>
          <td colspan="9">
            <table>
              <thead>
                <tr>
                  <th>KUANTITAS TERPAKAI</th>
                  <th>INVOICE PEMBELIAN</th>
                  <th>HARGA BELI PER UNIT</th>
                  <th>DISKON</th>
                  <th>TOTAL</th>
                </tr>
              </thead>

              <tbody>
                <?php
                  $histories = \DB::table('Sales_ItemPurchase_History')
                              ->where('sales_id', $model->sales_id)
                              ->where('item_id', $model->item_id)
                              ->get();
                  $grandPurchase = 0;
                ?>
                @if (count($histories) > 0)
                  @foreach ($histories as $history)
                    <?php
                      $purchaseHistory = \DB::table('Item_Purchase_History')->where('id', $history->history_id)->first();
                    ?>
                    <tr>
                      <td>{{ $history->quantity_used }}</td>
                      @if ($purchaseHistory)
                        <?php
                          $realUnitPrice = $purchaseHistory->unit_price;
                          if ($purchaseHistory->discount > 0) {
                            $realUnitPrice = $realUnitPrice - ($purchaseHistory->discount / $purchaseHistory->quantity);
                          }
                          $total = $realUnitPrice * $history->quantity_used;
                          $grandPurchase += $total;
                        ?>
                        <td>
                          @if ($purchase = \DB::table('Purchase')->where('id', $purchaseHistory->purchase_id)->first())
                            <a href="{{ route('purchase.invoice.print', ['id' => $purchase->id]) }}" target="_blank">{{ $purchase->invoice_id }}</a>
                          @else
                          -- Tidak ada data --
                          @endif
                        </td>
                        <td>{{ number_format($purchaseHistory->unit_price, 0) }}</td>
                        <td>
                          {{ number_format(($purchaseHistory->discount > 0) ? $realUnitPrice : 0, 0) }}
                        </td>
                        <td>
                          {{ number_format($total, 0) }}
                        </td>
                      @else
                        <td>-- Data tidak tersedia --</td>
                        <td>-- Data tidak tersedia --</td>
                      @endif
                    </tr>
                  @endforeach
                @endif
              </tbody>

              <tfoot>
                <tr>
                  <td colspan="4" align="right">TOTAL</td>
                  <td><strong>{{ number_format($grandPurchase, 0) }}</strong></td>
                </tr>

                <?php
                  $profit = $model->total - $grandPurchase;
                  $grandTotal += $profit;
                ?>
                <tr @if ($profit > 0) class="green" @else class="red" @endif>
                  <td colspan="4" align="right">
                    @if ($profit > 0) LABA @else RUGI @endif
                  </td>
                  <td><strong>{{ number_format(abs($profit) , 0) }}</strong></td>
                </tr>
              </tfoot>
            </table>
          </td>
        </tr>
      @endforeach
    @else
    <tr>
      <td colspan="9">Tidak ada data.</td>
    </tr>
    @endif
  </tbody>

  <tfoot>
    <tr @if ($grandTotal > 0) class="green" @else class="red" @endif>
      <td colspan="8" align="right">
        @if ($grandTotal > 0)
          LABA
        @else
          RUGI
        @endif
      </td>
      <td>{{ number_format(abs($grandTotal), 0) }}</td>
    </tr>
  </tfoot>
</table>

<!-- END SALES -->

@stop
