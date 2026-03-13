<!-- ── CREATE / EDIT MODAL ─────────────────────────────── -->
<div class="modal fade" id="result-modal" tabindex="-1" aria-labelledby="result-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="result-modal-title">Upload Result</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="result-form" novalidate enctype="multipart/form-data">
          @csrf

          <div class="row g-3">

            <!-- Polling Unit -->
            <div class="col-md-12">
              <label class="form-label fw-bold">Polling Unit</label>
              <select class="form-select" id="pu_id" name="pu_id">
                <option value="">Choose PU</option>
                @foreach($states as $state)
                  @foreach($state->zones as $zone)
                    @foreach($zone->lgas as $lga)
                      @foreach($lga->wards as $ward)
                        @foreach($ward->pus as $pu)
                          <option value="{{ $pu->id }}">
                            {{ $pu->number }}{{ $pu->name ? ' - ' . $pu->name : '' }}
                          </option>
                        @endforeach
                      @endforeach
                    @endforeach
                  @endforeach
                @endforeach
              </select>
              <div class="invalid-feedback" id="pu_id-error"></div>
            </div>

            <!-- Election -->
            <div class="col-md-12">
              <label class="form-label fw-bold">Election Type</label>
              <select class="form-select" id="election_id" name="election_id">
                <option value="">Choose Election</option>
                @foreach($elections as $election)
                  <option value="{{ $election->id }}">{{ $election->type }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="election_id-error"></div>
            </div>

            <!-- Image -->
            <div class="col-md-12">
              <label class="form-label fw-bold">
                Result Image <small id="image-hint" class="text-muted"></small>
              </label>
              <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png">
              <div class="invalid-feedback" id="image-error"></div>
            </div>

            <!-- Image Preview -->
            <div class="col-md-12 d-none" id="image-preview-wrapper">
              <img id="image-preview" src="" alt="Current result image"
                class="img-thumbnail" style="max-height: 150px;">
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="result-submit-btn">Upload Result</button>
            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>