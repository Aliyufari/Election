<div class="modal fade" id="update-cvr-figure-modal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">

      <form id="update-cvr-figure-form">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Update CVR Figure</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- CVR Type -->
          <input type="hidden" name="type" id="modal-cvr-type">

          <div class="mb-2">
            <small class="text-muted" id="modal-cvr-label"></small>
          </div>

          <!-- ================= LOCATION SELECTS ================= -->

          <div class="mb-2">
            <label class="form-label fw-semibold">State</label>
            <select id="modal-state" class="form-select form-select-sm">
              <option value="">Select State</option>
              @foreach ($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-2">
            <label class="form-label fw-semibold">Zone</label>
            <select id="modal-zone" class="form-select form-select-sm" disabled>
              <option value="">Select Zone</option>
            </select>
          </div>

          <div class="mb-2">
            <label class="form-label fw-semibold">LGA</label>
            <select id="modal-lga" class="form-select form-select-sm" disabled>
              <option value="">Select LGA</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Ward</label>
            <select
              name="ward_id"
              id="modal-ward"
              class="form-select form-select-sm"
              disabled
              required>
              <option value="">Select Ward</option>
            </select>
          </div>

          <!-- ================= FIGURE INPUT ================= -->

          <div class="mb-3">
            <label class="form-label fw-semibold">New Value</label>
            <input
              type="number"
              name="value"
              id="modal-cvr-value"
              class="form-control form-control-sm"
              min="0"
              required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-success btn-sm">
            Save
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
