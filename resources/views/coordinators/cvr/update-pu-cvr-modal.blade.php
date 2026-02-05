<div class="modal fade" id="update-pu-cvr-modal" tabindex="-1" aria-labelledby="update-pu-cvr-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="update-pu-cvr-modal-title">Add CVRs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="update-pu-cvr-form" novalidate>
          @csrf
          <input type="hidden" name="pu_id" id="modal-pu-id">

          <div class="mb-3">
            <label for="pu-cvr-count" class="form-label">Number of CVRs to add</label>
            <input type="number" class="form-control" id="pu-cvr-count" name="count" min="1" required>
            <div class="invalid-feedback" id="count-error"></div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
