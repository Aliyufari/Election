<!-- User Modal -->
<div class="modal fade" id="cvr-modal" tabindex="-1" aria-labelledby="user-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title" id="user-modal-title">Create CVR Login</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="user-form" class="needs-validation" novalidate>
                    <input type="hidden" id="user_id" name="user_id">

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="full-name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            <div class="invalid-feedback" id="username-error"></div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            <div class="invalid-feedback" id="password-error"></div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="invalid-feedback" id="gender-error"></div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role_id" required>
                                <option value="">Select role</option>
                            </select>
                            <div class="invalid-feedback" id="role-error"></div>
                        </div>

                        <!-- State -->
                        <div class="col-md-6" id="state-wrapper">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select" id="state" name="state_id" required>
                                <option value="">Select state</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="state-error"></div>
                        </div>

                        <!-- Zone -->
                        <div class="col-md-6 d-none" id="zone-wrapper">
                            <label for="zone" class="form-label">Zone</label>
                            <select class="form-select" id="zone" name="zone_id" required>
                                <option value="">Select zone</option>
                                {{-- Populated dynamically via state selection --}}
                            </select>
                            <div class="invalid-feedback"  id="zone-error"></div>
                        </div>

                        <!-- LGA -->
                        <div class="col-md-6 d-none" id="lga-wrapper">
                            <label for="lga" class="form-label">LGA</label>
                            <select class="form-select" id="lga" name="lga_id" required>
                                <option value="">Select LGA</option>
                                {{-- Populated dynamically via state selection --}}
                            </select>
                            <div class="invalid-feedback"  id="lga-error"></div>
                        </div>

                        <!-- Ward -->
                        <div class="col-md-6 d-none" id="ward-wrapper">
                            <label for="ward" class="form-label">Ward</label>
                            <select class="form-select" id="ward" name="ward_id">
                                <option value="">Select Ward</option>
                            </select>
                            <div class="invalid-feedback" id="ward-error"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 d-flex justify-content-end gap-2" id="action-btn">
                        <button type="submit" class="btn btn-primary me-2" id="submit-user">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
