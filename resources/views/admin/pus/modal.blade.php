<!-- ── CREATE / EDIT MODAL ─────────────────────────────── -->
<div class="modal fade" id="pu-modal" tabindex="-1" aria-labelledby="pu-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="pu-modal-title">Create Polling Unit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="pu-form" novalidate>
          @csrf

          <div class="row g-3">

            <!-- Number -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Number</label>
              <input type="text" class="form-control" id="number" name="number" placeholder="05-08-08-029">
              <div class="invalid-feedback" id="number-error"></div>
            </div>

            <!-- Name -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter PU name">
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

            <!-- Zone -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Zone</label>
              <select class="form-select" id="zone_id" name="zone_id">
                <option value="">Select Zone</option>
              </select>
              <div class="invalid-feedback" id="zone_id-error"></div>
            </div>

            <!-- LGA -->
            <div class="col-md-6">
              <label class="form-label fw-bold">LGA</label>
              <select class="form-select" id="lga_id" name="lga_id">
                <option value="">Select LGA</option>
              </select>
              <div class="invalid-feedback" id="lga_id-error"></div>
            </div>

            <!-- Ward -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Ward</label>
              <select class="form-select" id="ward_id" name="ward_id">
                <option value="">Select Ward</option>
              </select>
              <div class="invalid-feedback" id="ward_id-error"></div>
            </div>

            <!-- Description -->
            <div class="col-md-12">
              <label class="form-label fw-bold">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
              <div class="invalid-feedback" id="description-error"></div>
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="pu-submit-btn">Save PU</button>
            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Zones keyed by state_id
  window.puZonesData = @json($states->mapWithKeys(fn($s) => [
    $s->id => $s->zones->map(fn($z) => ['id' => $z->id, 'name' => $z->name])
  ]));

  // LGAs keyed by zone_id
  window.puLgasData = @json($states->flatMap(fn($s) => $s->zones)->mapWithKeys(fn($z) => [
    $z->id => $z->lgas->map(fn($l) => ['id' => $l->id, 'name' => $l->name])
  ]));

  // Wards keyed by lga_id
  window.puWardsData = @json($states->flatMap(fn($s) => $s->zones)->flatMap(fn($z) => $z->lgas)->mapWithKeys(fn($l) => [
    $l->id => $l->wards->map(fn($w) => ['id' => $w->id, 'name' => $w->name])
  ]));
</script>

<!-- ── VIEW MODAL ──────────────────────────────────────── -->
<div class="modal fade" id="pu-view-modal" tabindex="-1" aria-labelledby="pu-view-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="pu-view-modal-title">Polling Unit Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-4 text-muted fw-normal">Number</dt>
          <dd class="col-sm-8 fw-semibold" id="view-pu-number">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Name</dt>
          <dd class="col-sm-8 fw-semibold" id="view-pu-name">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">State</dt>
          <dd class="col-sm-8" id="view-pu-state">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Zone</dt>
          <dd class="col-sm-8" id="view-pu-zone">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">LGA</dt>
          <dd class="col-sm-8" id="view-pu-lga">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Ward</dt>
          <dd class="col-sm-8" id="view-pu-ward">—</dd>

          <dt class="col-sm-4 text-muted fw-normal">Description</dt>
          <dd class="col-sm-8" id="view-pu-description">—</dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>