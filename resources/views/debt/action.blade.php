<div class="btn-group">
  <a href="{{ route('debt.detail', ['id' => $model->id]) }}" class="btn btn-info" target="_blank">
    <i class="fa fa-eye mr-5"></i> Detail
  </a>

  <button class="btn btn-danger btn-delete" data-url="{{ route('debt.delete', ['id' => $model->id]) }}">
    <i class="fa fa-trash mr-5"></i> Hapus
  </button>
</div>
