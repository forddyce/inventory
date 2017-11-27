<div class="btn-group">
  <a href="{{ route('sales.invoice.print', ['id' => $model->id]) }}" class="btn btn-info" target="_blank">
    <i class="fa fa-eye mr-5"></i> Detail
  </a>

  @if (!$model->is_complete)
    @if ($debt = $model->debt)
      <a href="{{ route('debt.detail', ['id' => $debt->id]) }}" target="_blank" class="btn btn-warning">
        <i class="fa fa-pencil mr-5"></i> Data Hutang
      </a>
    @endif
  @endif

  <button class="btn btn-danger btn-delete" data-url="{{ route('sales.delete', ['id' => $model->id]) }}">
    <i class="fa fa-trash mr-5"></i> Hapus
  </button>
</div>
