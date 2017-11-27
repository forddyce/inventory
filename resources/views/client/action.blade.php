<div class="btn-group">
  <a href="{{ route('client.edit', ['id' => $model->id]) }}" class="btn btn-warning">
    <i class="fa fa-pencil mr-5"></i> Edit
  </a>

  <button class="btn btn-danger btn-delete" data-url="{{ route('client.delete', ['id' => $model->id]) }}">
    <i class="fa fa-trash mr-5"></i> Hapus
  </button>
</div>
