@if(!empty($type) && $type === 'full-view')
  <button type="button" class="btn btn-danger mb-3 {{ $class ?? '' }}" data-bs-toggle="modal" data-bs-target="#cancel-{{ $type }}-{{ $id }}">
    Cancel
  </button>
@else
<button type="button" class="btn btn-danger btn-sm ms-2 {{ $class ?? '' }}" data-bs-toggle="modal" data-bs-target="#cancel-{{ $type }}-{{ $id }}"><i class="fa-solid fa-xmark"></i></button>
@endif
<form method="POST" enctype="multipart/form-data" action="{{ $url }}" data-ajax="true">
  <input type="hidden" name="id" value="{{ $id }}">
  <div class="modal fade" id="cancel-{{ $type }}-{{ $id }}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="exampleModalLabel">Do you want to <strong class="text-danger">&nbsp;cancel&nbsp;</strong>this item?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Select "Confirm" below if you are continue this action.</p>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</form>