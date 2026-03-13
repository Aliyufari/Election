<!-- ── CREATE / EDIT MODAL ─────────────────────────────── -->
<div class="modal fade" id="state-modal" tabindex="-1" aria-labelledby="state-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="state-modal-title">Create State</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="state-form" novalidate>
          @csrf
          <div class="row g-3">

            <div class="col-md-12">
              <label class="form-label fw-bold">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter state name">
              <div class="invalid-feedback" id="name-error"></div>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
              <div class="invalid-feedback" id="description-error"></div>
            </div>

          </div>
          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="state-submit-btn">Save State</button>
            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ── VIEW MODAL ──────────────────────────────────────── -->
<div class="modal fade" id="state-view-modal" tabindex="-1" aria-labelledby="state-view-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="state-view-modal-title">State Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-4 text-muted fw-normal">Name</dt>
          <dd class="col-sm-8 fw-semibold" id="view-state-name">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Description</dt>
          <dd class="col-sm-8" id="view-state-description">—</dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>