<!-- ── CREATE / EDIT MODAL ─────────────────────────────── -->
<div class="modal fade" id="election-modal" tabindex="-1" aria-labelledby="election-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="election-modal-title">Create Election</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="election-form" novalidate>
          @csrf

          <div class="row g-3">

            <!-- Type -->
            <div class="col-md-12">
              <label class="form-label fw-bold">Election Type</label>
              <select class="form-select" id="type" name="type">
                <option value="">Choose Election Type</option>
                @foreach([
                  'Presidential election',
                  'Governorship election',
                  'Senatorial election',
                  'House of Representatives election',
                  'House of Assembly election',
                  'Chairmanship',
                  'Councillor',
                ] as $type)
                  <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="type-error"></div>
            </div>

            <!-- Date -->
            <div class="col-md-12">
              <label class="form-label fw-bold">Election Date</label>
              <input type="date" class="form-control" id="date" name="date">
              <div class="invalid-feedback" id="date-error"></div>
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="election-submit-btn">Save Election</button>
            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ── VIEW MODAL ──────────────────────────────────────── -->
<div class="modal fade" id="election-view-modal" tabindex="-1" aria-labelledby="election-view-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="election-view-modal-title">Election Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-4 text-muted fw-normal">Type</dt>
          <dd class="col-sm-8 fw-semibold" id="view-election-type">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Date</dt>
          <dd class="col-sm-8" id="view-election-date">—</dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>