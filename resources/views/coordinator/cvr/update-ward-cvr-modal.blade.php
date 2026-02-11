<!-- Small Update CVR Modal -->
<div class="modal fade" id="update-cvr-modal" tabindex="-1" aria-labelledby="update-cvr-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="update-cvr-modal-title">Update CVRs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="update-cvr-form" novalidate>
          @csrf
          <input type="hidden" name="ward_id" id="modal-ward-id">

          <div class="mb-3">
            <label for="cvr-count" class="form-label">Number of CVRs to add</label>
            <input type="number" class="form-control" id="cvr-count" name="count" min="1" required>
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