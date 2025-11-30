<!-- User Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="user-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title" id="user-modal-title">Create User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="user-form" class="needs-validation" novalidate>
                    <input type="hidden" id="user_id" name="user_id">

                    <div class="row g-3">

                        <!-- Full Name -->
                        <div class="col-md-4">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name">
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-4">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                            <div class="invalid-feedback" id="username-error"></div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Enter phone">
                            <div class="invalid-feedback" id="phone-error"></div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-4">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            <div class="invalid-feedback" id="password-error"></div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <div class="invalid-feedback" id="gender-error"></div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-4">
                            <label class="form-label">Role</label>
                            <select class="form-select" id="role" name="role_id">
                                <option value="">Select role</option>
                            </select>
                            <div class="invalid-feedback" id="role-error"></div>
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
                            <label class="form-label">State Zone</label>
                            <select class="form-select" id="zone" name="zone_id">
                                <option value="">Select zone</option>
                            </select>
                            <div class="invalid-feedback" id="zone-error"></div>
                        </div>

                        <!-- LGA -->
                        <div class="col-md-4">
                            <label class="form-label">LGA</label>
                            <select class="form-select" id="lga" name="lga_id">
                                <option value="">Select LGA</option>
                            </select>
                            <div class="invalid-feedback" id="lga-error"></div>
                        </div>

                        <!-- Ward -->
                        <div class="col-md-4">
                            <label class="form-label">Ward</label>
                            <select class="form-select" id="ward" name="ward_id">
                                <option value="">Select ward</option>
                            </select>
                            <div class="invalid-feedback" id="ward-error"></div>
                        </div>

                        <!-- PU -->
                        <div class="col-md-4">
                            <label class="form-label">PU</label>
                            <select class="form-select" id="pu" name="pu_id">
                                <option value="">Select PU</option>
                            </select>
                            <div class="invalid-feedback" id="pu-error"></div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 d-flex justify-content-end gap-2" id="action-btn">
                        <button type="submit" class="btn btn-primary me-2" id="submit-user">Save User</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
