@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.coordinator.sidebar')
@endsection

@section('content')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>CVR Panel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item">CVR Panel</li>
          <li class="breadcrumb-item active">CVR Logins</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- LGA Logins List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto border-0 shadow-sm">

              <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0 text-dark fw-bold">CVR Logins</h5>
                  <button id="create-cvr-login" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Create CVR Login
                  </button>
                </div>
                <p class="text-muted mt-2 mb-0">Manage LGA Loggins</p>
              </div>

              <div class="card-body pt-3">
                <div class="table-responsive" id="cvr-table-container">
                  <table class="table table-hover table-borderless">
                    <thead class="table-light">
                      <tr>
                        <th class="ps-3">#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>LGA</th>
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
                          <td>{{ $user->role->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                            <span class="badge bg-secondary rounded-pill">{{ $user->gender }}</span>
                          </td>
                          <td>{{ "Bauchi" }}</td>
                          <td class="text-center pe-3">
                            <div class="btn-group" role="group">
                              <a href="/coordinator/users/{{ $user->id }}" class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                              </a>
                              <a href="/coordinator/users/{{ $user->id }}/edit" class="btn btn-sm btn-outline-success" title="Edit">
                                <i class="bi bi-pencil"></i>
                              </a>
                              <form method="POST" action="/coordinator/users/{{ $user->id }}" class="d-inline">
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

  @include('coordinator.cvr.modal')


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
$(document).ready(function () {

  /* ---------------- CSRF ---------------- */
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  /* ---------------- MODAL ---------------- */
  const cvrModalEl = document.getElementById('cvr-modal');
  const cvrModal = new bootstrap.Modal(cvrModalEl);

  cvrModalEl.addEventListener('hidden.bs.modal', function () {
    $('#user-form')[0].reset();
    $('#action-btn').html('');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    // Reset visibility
    toggleLocationFields(null);
  });

  $('#create-cvr-login').on('click', function (e) {
    e.preventDefault();

    $('#user-modal-title').text('Create CVR Login');
    $('#action-btn').html(`
      <button type="submit" class="btn btn-primary">Save User</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    `);

    getRoles();
    cvrModal.show();
  });

  /* ---------------- ROLE HANDLING ---------------- */

  function hideAllLocationInputs() {
    $('#state-wrapper, #zone-wrapper, #lga-wrapper, #ward-wrapper')
          .addClass('d-none'); // hide
  }

  function showField(selector) {
      $(selector).removeClass('d-none'); // show
  }

  function toggleLocationFields(roleName) {
    hideAllLocationInputs();

    if (!roleName) return;

    if (roleName.includes('zonal_coordinator')) {
        showField('#state-wrapper');
        showField('#zone-wrapper');
    }

    if (roleName.includes('lga_coordinator')) {
        showField('#state-wrapper');
        showField('#zone-wrapper');
        showField('#lga-wrapper');
    }

    if (roleName.includes('ward_coordinator')) {
        showField('#state-wrapper');
        showField('#zone-wrapper');
        showField('#lga-wrapper');
        showField('#ward-wrapper');
    }
  }

  $('#role').on('change', function () {
    const roleName = $('#role option:selected').data('name');
    toggleLocationFields(roleName);
  });

  /* ---------------- FETCH ROLES ---------------- */

  function getRoles() {
    $.get('/coordinator/roles', function (data) {

      let options = `<option value="">Select role</option>`;

      data.roles
        .filter(role => role.name.includes('coordinator'))
        .forEach(role => {

          const displayName = role.name
            .replace(/_/g, ' ')
            .replace(/\b\w/g, c => c.toUpperCase());

          options += `
            <option value="${role.id}" data-name="${role.name}">
              ${displayName}
            </option>`;
        });

      $('#role').html(options);
    });
  }

  /* ---------------- STATE → LGA ---------------- */

  $('#state').on('change', function () {
    const stateId = $(this).val();
    $('#zone').html('<option value="">Loading...</option>');
    $('#lga').html('<option value="">Select LGA</option>');
    $('#ward').html('<option value="">Select Ward</option>');

    if (!stateId) {
      $('#zone').html('<option value="">Select zone</option>');
      return;
    }

    $.get(`/coordinator/states/${stateId}`, function (data) {
      let options = '<option value="">Select zone</option>';
      console.log(data.state);
      
      data.state.zones.forEach(zone => {
        options += `<option value="${zone.id}">${zone.name}</option>`;
      });
      $('#zone').html(options);
    });
  });

  /* ---------------- STATE → LGA ---------------- */

  $('#zone').on('change', function () {
    const zoneId = $(this).val();

    $('#lga').html('<option value="">Loading...</option>');
    $('#ward').html('<option value="">Select Ward</option>');

    if (!zoneId) {
      $('#lga').html('<option value="">Select LGA</option>');
      return;
    }

    $.get(`/coordinator/zones/${zoneId}`, function (data) {
      let options = '<option value="">Select LGA</option>';
      data.zone.lgas.forEach(lga => {
        options += `<option value="${lga.id}">${lga.name}</option>`;
      });
      $('#lga').html(options);
    });
  });

  /* ---------------- LGA → WARD ---------------- */

  $('#lga').on('change', function () {
    const lgaId = $(this).val();
    $('#ward').html('<option value="">Loading...</option>');

    if (!lgaId) {
      $('#ward').html('<option value="">Select Ward</option>');
      return;
    }

    $.get(`/coordinator/lgas/${lgaId}`, function (data) {
      let options = '<option value="">Select Ward</option>';
      data.lga.wards.forEach(ward => {
        options += `<option value="${ward.id}">${ward.name}</option>`;
      });
      $('#ward').html(options);
    });
  });

  /* ---------------- SUBMIT ---------------- */

  $('#user-form').on('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      type: 'POST',
      url: '/coordinator/cvr/logins',
      data: formData,
      processData: false,
      contentType: false,
      success(response) {
        handleResponse(response);
      },
      error(xhr) {
        if (xhr.status === 422) {
          handleResponse(xhr.responseJSON);
        } else {
          toastr.error('Something went wrong');
        }
      }
    });
  });

  /* ---------------- RESPONSE HANDLER ---------------- */

  function handleResponse(response) {
    const errors = response.errors || {};

    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    $.each(errors, function (field, messages) {
      $(`#${field}`).addClass('is-invalid');
      $(`#${field}-error`).text(messages[0]).show();
    });

    if (response.status) {
      cvrModal.hide();
      toastr.success(response.message);
      $('#cvr-table-container')
        .load(location.href + ' #cvr-table-container > *');
    }
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection