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

            <!-- Role -->
            <div class="col-md-6">
              <label class="form-label">Role</label>
              <select class="form-select" id="role" name="role_id">
                <option value="">Select role</option>
                @php
                  $allowedRoles = $authUser->isStateCoordinator()
                    ? ['zonal_coordinator', 'lga_coordinator', 'ward_coordinator']
                    : ($authUser->isZonalCoordinator()
                      ? ['lga_coordinator', 'ward_coordinator']
                      : ($authUser->isLgaCoordinator()
                        ? ['ward_coordinator']
                        : []));
                @endphp
                @foreach(\App\Models\Role::whereIn('name', $allowedRoles)->get() as $role)
                  <option value="{{ $role->id }}" data-name="{{ $role->name }}">
                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                  </option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="role-error"></div>
            </div>

            <!-- Zone -->
            @if($authUser->isStateCoordinator())
            <div class="col-md-6 d-none" id="zone-wrapper">
              <label class="form-label">Zone</label>
              <select class="form-select" id="zone" name="zone_id">
                <option value="">Select zone</option>
                @foreach($zones as $zone)
                  <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="zone-error"></div>
            </div>
            @else
              @if($authUser->zone_id)
                <input type="hidden" name="zone_id" value="{{ $authUser->zone_id }}">
              @endif
            @endif

            <!-- LGA -->
            @if($authUser->isStateCoordinator())
            <div class="col-md-6 d-none" id="lga-wrapper">
              <label class="form-label">LGA</label>
              <select class="form-select" id="lga" name="lga_id">
                <option value="">Select LGA</option>
              </select>
              <div class="invalid-feedback" id="lga-error"></div>
            </div>
            @elseif($authUser->isZonalCoordinator())
            <div class="col-md-6 d-none" id="lga-wrapper">
              <label class="form-label">LGA</label>
              <select class="form-select" id="lga" name="lga_id">
                <option value="">Select LGA</option>
                @foreach($lgas as $lga)
                  <option value="{{ $lga->id }}">{{ $lga->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="lga-error"></div>
            </div>
            @else
              @if($authUser->lga_id)
                <input type="hidden" name="lga_id" value="{{ $authUser->lga_id }}">
              @endif
            @endif

            <!-- Ward -->
            @if($authUser->isStateCoordinator() || $authUser->isZonalCoordinator())
            <div class="col-md-6 d-none" id="ward-wrapper">
              <label class="form-label">Ward</label>
              <select class="form-select" id="ward" name="ward_id">
                <option value="">Select Ward</option>
              </select>
              <div class="invalid-feedback" id="ward-error"></div>
            </div>
            @elseif($authUser->isLgaCoordinator())
            <div class="col-md-6 d-none" id="ward-wrapper">
              <label class="form-label">Ward</label>
              <select class="form-select" id="ward" name="ward_id">
                <option value="">Select Ward</option>
                @foreach($wards as $ward)
                  <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="ward-error"></div>
            </div>
            @endif

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