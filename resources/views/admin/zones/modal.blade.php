<!-- ── CREATE / EDIT MODAL ─────────────────────────────── -->
<div class="modal fade" id="zone-modal" tabindex="-1" aria-labelledby="zone-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="zone-modal-title">Create Zone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="zone-form" novalidate>
          @csrf
          <div class="row g-3">

            <!-- Name -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter zone name">
              <div class="invalid-feedback" id="name-error"></div>
            </div>

            <!-- State -->
            <div class="col-md-6">
              <label class="form-label fw-bold">State</label>
              <select class="form-select" id="state_id" name="state_id">
                <option value="">Choose State</option>
                @foreach($states as $state)
                  <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="state_id-error"></div>
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <label class="form-label fw-bold">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
              <div class="invalid-feedback" id="description-error"></div>
            </div>

          </div>
          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="zone-submit-btn">Save Zone</button>
            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ── VIEW MODAL ──────────────────────────────────────── -->
<div class="modal fade" id="zone-view-modal" tabindex="-1" aria-labelledby="zone-view-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="zone-view-modal-title">Zone Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-4 text-muted fw-normal">Name</dt>
          <dd class="col-sm-8 fw-semibold" id="view-zone-name">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">State</dt>
          <dd class="col-sm-8" id="view-zone-state">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Description</dt>
          <dd class="col-sm-8" id="view-zone-description">—</dd>
        </dl>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>