<!-- modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white mb-1">Hapus Data</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="row g-2">
          <div class="col mb-0 display-6">
            Ingin menghapus data ini?
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <form class="d-inline" method="POST" id="hapus" >
          @method('delete')
          @csrf
          <button type="submit" class="btn btn-md btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
