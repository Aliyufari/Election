<!-- User Modal -->
<div class="modal fade" id="cvr-modal" tabindex="-1" aria-labelledby="user-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="user-modal-title">Create CVR Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="user-form" novalidate>
          @csrf
          <input type="hidden" id="user_id" name="user_id">

          <div class="row g-3">

            <!-- Full Name -->
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name">
              <div class="invalid-feedback" id="name-error"></div>
            </div>

            <!-- Username -->
            <div class="col-md-6">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
              <div class="invalid-feedback" id="username-error"></div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
              <div class="invalid-feedback" id="email-error"></div>
            </div>

            <!-- Password -->
            <div class="col-md-6">
              <label class="form-label">
                Password <small id="password-hint" class="text-muted"></small>
              </label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
              <div class="invalid-feedback" id="password-error"></div>
            </div>

            <!-- Gender -->
            <div class="col-md-6">
              <label class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender">
                <option value="">Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="Other">Other</option>
              </select>
              <div class="invalid-feedback" id="gender-error"></div>
            </div>

            <!-- Role — admin sees all coordinator roles -->
            <div class="col-md-6">
              <label class="form-label">Role</label>
              <select class="form-select" id="role" name="role_id">
                <option value="">Select role</option>
                @foreach(\App\Models\Role::where('name', 'like', '%coordinator%')->get() as $role)
                  <option value="{{ $role->id }}" data-name="{{ $role->name }}">
                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                  </option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="role-error"></div>
            </div>

            <!-- State -->
            <div class="col-md-6 d-none" id="state-wrapper">
              <label class="form-label">State</label>
              <select class="form-select" id="state" name="state_id">
                <option value="">Select state</option>
                @foreach($states as $state)
                  <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="state-error"></div>
            </div>

            <!-- Zone — populated via AJAX on state change -->
            <div class="col-md-6 d-none" id="zone-wrapper">
              <label class="form-label">Zone</label>
              <select class="form-select" id="zone" name="zone_id">
                <option value="">Select zone</option>
              </select>
              <div class="invalid-feedback" id="zone-error"></div>
            </div>

            <!-- LGA — populated via AJAX on zone change -->
            <div class="col-md-6 d-none" id="lga-wrapper">
              <label class="form-label">LGA</label>
              <select class="form-select" id="lga" name="lga_id">
                <option value="">Select LGA</option>
              </select>
              <div class="invalid-feedback" id="lga-error"></div>
            </div>

            <!-- Ward — populated via AJAX on LGA change -->
            <div class="col-md-6 d-none" id="ward-wrapper">
              <label class="form-label">Ward</label>
              <select class="form-select" id="ward" name="ward_id">
                <option value="">Select Ward</option>
              </select>
              <div class="invalid-feedback" id="ward-error"></div>
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="user-submit-btn">Save User</button>
            <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>