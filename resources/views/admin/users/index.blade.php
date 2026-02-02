@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.sidebar')
@endsection

@section('content')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Users Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- Users List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto border-0 shadow-sm">

              <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0 text-dark fw-bold">Users List</h5>
                  {{-- <a href="/admin/users/create" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Create User
                  </a> --}}
                  <button type="button" id="createn-user-btn" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Create User
                  </button>
                </div>
                <p class="text-muted mt-2 mb-0">Manage all users in the system</p>
              </div>

              <div class="card-body pt-3">
                <div class="table-responsive" id="user-table-container">
                  <table class="table table-hover table-borderless">
                    <thead class="table-light">
                      <tr>
                        <th class="ps-3">#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Image</th>
                        <th>Role</th>
                        <th class="text-center pe-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                      @if(strtolower($user->role) !== 'super')
                        <tr class="border-bottom">
                          <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                          <td class="fw-semibold text-dark">{{ $user->name }}</td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                            <span class="badge bg-secondary rounded-pill">{{ $user->gender }}</span>
                          </td>
                          <td>
                            <a href="/admin/users/{{ $user->id }}">
                              <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/img/users/user.jpg') }}" 
                                   style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" 
                                   alt="{{ $user->name }}" 
                                   title="View {{ $user->name }}">
                            </a>
                          </td>
                          <td>
                            <span class="badge 
                              @if(strtolower($user->role->name) === 'user')
                                bg-warning
                              @elseif(strtolower($user->role->name) === 'admin')
                                bg-success
                              @elseif(strtolower($user->role->name) === 'ratech')
                                bg-primary
                              @else
                                bg-info
                              @endif  
                            rounded-pill">
                              {{ $user->role->name }}
                            </span>
                          </td>
                          <td class="text-center pe-3">
                            <div class="btn-group" role="group">
                              <a href="/admin/users/{{ $user->id }}" class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                              </a>
                              <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-outline-success" title="Edit">
                                <i class="bi bi-pencil"></i>
                              </a>
                              <form method="POST" action="/admin/users/{{ $user->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      @endif 
                    @endforeach
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                  <div class="text-muted small">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
                  </div>
                  <div>
                    {{ $users->links() }}
                  </div>
                </div>
            
              </div>

            </div>
          </div><!-- End Users List -->

      </div>
    </section>

  </main><!-- End #main -->

  @include('admin.users.modal')

  <style>
    .table > :not(caption) > * > * {
      padding: 0.75rem 0.5rem;
    }
    .btn-group .btn {
      margin: 0 2px;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.02);
    }
  </style>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('script')
<script>
$(document).ready(function() {

  // CSRF setup
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  // Bootstrap modal instance
  const userModalEl = document.getElementById('user-modal');
  const userModal = new bootstrap.Modal(userModalEl);

  // Reset form when modal hides
  userModalEl.addEventListener('hidden.bs.modal', function () {
      $('#user-form')[0].reset();
      $('#action-btn').html('');
      $('.is-invalid').removeClass('is-invalid');
  });

  $('#createn-user-btn').on('click', function(e) {
      e.preventDefault();
      $('#user-modal-title').text('Create User');

      $('#action-btn').html(`
          <button type="submit" class="btn btn-primary" id="submit-user">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      `);

      userModal.show();
  });

  $('#user-form').on('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
      type: "POST",
      url: "/admin/states/create",
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(response) {
          handleResponse(response);
      },
      error: function(xhr) {
          if (xhr.status === 422) {
              const response = xhr.responseJSON;
              handleResponse(response); 
          } else {
              toastr.error('Something went wrong', 'Error');
          }
      }
    });
  });

  // Optional: Populate zones dynamically based on state
  $('#state').on('change', function() {
    const stateId = $(this).val();

    $('#zone').html('<option disabled selected value="">Loading...</option>');

    if (!stateId) {
        $('#zone').html('<option disabled selected value="">Select zone</option>');
        return;
    }

    $.get({
      url: `/admin/states/${stateId}`,
      dataType: 'json',  
      success: function(data) {
          let options = '<option value="">Select zone</option>';

          data.state.zones.forEach(zone => {
              options += `<option value="${zone.id}">${zone.name}</option>`;
          });

          $('#zone').html(options);
      }
    });
  });

  // Optional: Populate LGA dynamically based on state
  $('#zone').on('change', function() {
    const zoneId = $(this).val();

    $('#lga').html('<option value="">Loading...</option>');

    if (!zoneId) {
        $('#lga').html('<option disabled selected value="">Select LGA</option>');
        return;
    }

    $.get({
      url: `/admin/zones/${zoneId}`,
      dataType: 'json',  
      success: function(data) {
          let options = '<option disabled selected value="">Select LGA</option>';
console.log("Zone: ", data.zone);

          data.zone.lgas.forEach(lga => {
              options += `<option value="${lga.id}">${lga.name}</option>`;
          });

          $('#lga').html(options);
      }
    });
  });

  const getRoles = () => {
    $.get({
        url: '/admin/roles',
        dataType: 'json',
        success: function(data) {

            let options = `<option disabled selected value="">Select role</option>`;

            data.roles
                .filter(role => !role.name?.toLowerCase().includes('coodinator'))
                .forEach(role => {

                    let displayName = role.name
                      .replace(/_/g, " ")        
                      .replace(/\b\w/g, c => c.toUpperCase()); 

                    options += `<option value="${role.id}">${displayName}</option>`;
                });

            $("#role").html(options);
        }
    });
  }
  getRoles()

  function handleResponse(response) {
    const errors = response.errors || {};

    const errorMapping = {
      name: '#name-error',
      username: '#username-error',
      email: '#email-error',
      phone: '#phone-error',
      password: '#password-error',
      gender: '#gender-error',
      role_id: '#role-error',
      state_id: '#state-error',
      zone_id: '#zone-error',
      lga_id: '#lga-error',
      ward_id: '#ward-error',
      pu_id: '#pu-error',
    };

    // Clear all previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('').hide();

    // Apply new errors
    $.each(errorMapping, (key, feedbackElement) => {
      const errorMessage = errors[key];
      if (errorMessage) {
        $(`#${key}`).addClass('is-invalid');

        $(feedbackElement)
          .text(errorMessage[0])
          .css('display', 'block');
      }
    });

    // Image upload errors (if any)
    if (errors.image) {
      toastr.error(errors.image[0], 'Error');
    }

    // Success handling
    if (response.status) {
      $('#user-modal').modal('hide'); // Hide modal
      toastr.success(response.message, 'Success');

      // Reload table container
      $("#user-table-container").load(location.href + " #user-table-container > *");
    }
  }
});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection