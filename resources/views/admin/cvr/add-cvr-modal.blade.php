<!-- CVR Modal -->
<div class="modal fade" id="cvr-modal" tabindex="-1" aria-labelledby="cvr-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">

      <div class="modal-header">
        <h5 class="modal-title" id="cvr-modal-title">Create CVR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="cvr-form" novalidate>
          @csrf

          <div class="row g-3">

            <!-- Unique ID -->
            <div class="col-md-6">
              <label class="form-label">CVR Unique ID</label>
              <input type="text" class="form-control" id="unique_id" name="unique_id">
              <div class="invalid-feedback" id="unique_id-error"></div>
            </div>

            <!-- CVR Type -->
            <div class="col-md-6">
              <label class="form-label">CVR Type</label>
              <select class="form-select" name="type" id="type">
                <option value="">Select type</option>
                <option value="registration">Registration</option>
                <option value="transfer">Transfer</option>
                <option value="update">Update</option>
              </select>
              <div class="invalid-feedback" id="type-error"></div>
            </div>

            <!-- State -->
            <div class="col-md-4">
              <label class="form-label">State</label>
              <select class="form-select" id="state" name="state_id">
                <option value="">Select state</option>
                @foreach($states as $state)
                  <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="state-error"></div>
            </div>

            <!-- Zone -->
            <div class="col-md-4">
              <label class="form-label">Zone</label>
              <select class="form-select" id="zone" name="zone_id" disabled>
                <option value="">Select zone</option>
              </select>
              <div class="invalid-feedback" id="zone-error"></div>
            </div>

            <!-- LGA -->
            <div class="col-md-4">
              <label class="form-label">LGA</label>
              <select class="form-select" id="lga" name="lga_id" disabled>
                <option value="">Select LGA</option>
              </select>
              <div class="invalid-feedback" id="lga-error"></div>
            </div>

            <!-- Ward -->
            <div class="col-md-4">
              <label class="form-label">Ward</label>
              <select class="form-select" id="ward" name="ward_id" disabled>
                <option value="">Select ward</option>
              </select>
              <div class="invalid-feedback" id="ward-error"></div>
            </div>

            <!-- PU -->
            <div class="col-md-4">
              <label class="form-label">Polling Unit</label>
              <select class="form-select" id="pu" name="pu_id" disabled>
                <option value="">Select PU</option>
              </select>
              <div class="invalid-feedback" id="pu-error"></div>
            </div>

            <!-- Status -->
            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select class="form-select" name="status" id="status">
                <option value="">Select status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </select>
              <div class="invalid-feedback" id="status-error"></div>
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="cvr-submit-btn">Save CVR</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>