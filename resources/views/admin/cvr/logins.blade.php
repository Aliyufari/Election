@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.admin.sidebar')
@endsection

@section('content')
@php $authUser = auth()->user(); @endphp
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
  </div>

  <section class="section dashboard">
    <div class="row">

      <div class="col-12">
        <div class="card recent-sales overflow-auto border-0 shadow-sm">

          <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0 text-dark fw-bold">CVR Logins</h5>
              <button id="create-cvr-login" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Create CVR Login
              </button>
            </div>
            <p class="text-muted mt-2 mb-0">Manage CVR Logins</p>
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
                    <th>State</th>
                    <th>Zone</th>
                    <th>LGA</th>
                    <th>Ward</th>
                    <th class="text-center pe-3">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                    <tr class="border-bottom">
                      <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                      <td class="fw-semibold text-dark">{{ $user->name }}</td>
                      <td>{{ $user->username }}</td>
                      <td>
                        <span class="badge bg-primary rounded-pill">
                          {{ ucwords(str_replace('_', ' ', $user->role->name)) }}
                        </span>
                      </td>
                      <td>{{ $user->email }}</td>
                      <td>
                        <span class="badge bg-secondary rounded-pill">{{ $user->gender }}</span>
                      </td>
                      <td>
                        @if($user->state)
                          <span class="badge bg-dark rounded-pill">{{ $user->state->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        @if($user->zone)
                          <span class="badge bg-warning rounded-pill">{{ $user->zone->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        @if($user->lga)
                          <span class="badge bg-info rounded-pill">{{ $user->lga->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        @if($user->ward)
                          <span class="badge bg-success rounded-pill">{{ $user->ward->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td class="text-center pe-3">
                        <div class="btn-group" role="group">
                          <a href="/admin/users/{{ $user->id }}" class="btn btn-sm btn-outline-primary" title="View">
                            <i class="bi bi-eye"></i>
                          </a>
                          <a href="#" class="btn btn-sm btn-outline-success edit-user-btn"
                            title="Edit"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-username="{{ $user->username }}"
                            data-email="{{ $user->email }}"
                            data-gender="{{ $user->gender }}"
                            data-role_id="{{ $user->role_id }}"
                            data-role_name="{{ $user->role->name }}"
                            data-state_id="{{ $user->state_id ?? '' }}"
                            data-zone_id="{{ $user->zone_id ?? '' }}"
                            data-lga_id="{{ $user->lga_id ?? '' }}"
                            data-ward_id="{{ $user->ward_id ?? '' }}">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <button type="button" class="btn btn-sm btn-outline-danger delete-user-btn"
                            title="Delete"
                            data-id="{{ $user->id }}">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
              <div class="text-muted small">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
              </div>
              <div>{{ $users->links() }}</div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>

</main>

@include('admin.cvr.modal')

<style>
  .table > :not(caption) > * > * { padding: 0.75rem 0.5rem; }
  .btn-group .btn { margin: 0 2px; }
  .table-hover tbody tr:hover { background-color: rgba(0,0,0,0.02); }
</style>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('script')
<script>
$(document).ready(function () {

  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  const cvrModalEl = document.getElementById('cvr-modal');
  const cvrModal   = new bootstrap.Modal(cvrModalEl);
  let editingId    = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    cvrModal.hide();
  });

  // ── RESET ON CLOSE ───────────────────────────────────────
  cvrModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#user-form')[0].reset();
    $('#password-hint').text('');
    hideAllLocationFields();
    clearErrors();

    const focused = document.activeElement;
    if (focused && cvrModalEl.contains(focused)) focused.blur();
    $('#create-cvr-login').trigger('focus');

    // Clear AJAX-populated selects
    $('#zone').html('<option value="">Select zone</option>');
    $('#lga').html('<option value="">Select LGA</option>');
    $('#ward').html('<option value="">Select Ward</option>');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-cvr-login').on('click', function () {
    editingId = null;
    $('#user-modal-title').text('Create CVR Login');
    $('#user-submit-btn').text('Save User');
    $('#password-hint').text('');
    hideAllLocationFields();
    clearErrors();
    cvrModal.show();
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-user-btn', function () {
    const btn      = $(this);
    editingId      = btn.data('id');
    const roleName = btn.data('role_name');
    const stateId  = btn.data('state_id');
    const zoneId   = btn.data('zone_id');
    const lgaId    = btn.data('lga_id');
    const wardId   = btn.data('ward_id');

    $('#user-modal-title').text('Edit CVR Login');
    $('#user-submit-btn').text('Update User');
    $('#password-hint').text('(leave blank to keep current)');
    clearErrors();

    $('#name').val(btn.data('name'));
    $('#username').val(btn.data('username'));
    $('#email').val(btn.data('email'));
    $('#gender').val(btn.data('gender'));
    $('#role').val(btn.data('role_id'));
    $('#password').val('');

    toggleLocationFields(roleName);

    // Admin cascades: state → zone → lga → ward all via AJAX
    if (stateId) {
      $('#state').val(stateId);

      $.get(`/admin/states/${stateId}`, function (data) {
        let zOptions = '<option value="">Select zone</option>';
        data.state.zones.forEach(z => {
          const sel = z.id == zoneId ? 'selected' : '';
          zOptions += `<option value="${z.id}" ${sel}>${z.name}</option>`;
        });
        $('#zone').html(zOptions);

        if (zoneId) {
          $.get(`/admin/zones/${zoneId}`, function (data) {
            let lOptions = '<option value="">Select LGA</option>';
            data.zone.lgas.forEach(l => {
              const sel = l.id == lgaId ? 'selected' : '';
              lOptions += `<option value="${l.id}" ${sel}>${l.name}</option>`;
            });
            $('#lga').html(lOptions);

            if (lgaId) {
              $.get(`/admin/lgas/${lgaId}`, function (data) {
                let wOptions = '<option value="">Select Ward</option>';
                data.lga.wards.forEach(w => {
                  const sel = w.id == wardId ? 'selected' : '';
                  wOptions += `<option value="${w.id}" ${sel}>${w.name}</option>`;
                });
                $('#ward').html(wOptions);
              });
            }
          });
        }
      });
    }

    cvrModal.show();
  });

  // ── ROLE CHANGE ──────────────────────────────────────────
  $('#role').on('change', function () {
    const roleName = $(this).find('option:selected').data('name');
    toggleLocationFields(roleName);
  });

  function hideAllLocationFields() {
    $('#state-wrapper, #zone-wrapper, #lga-wrapper, #ward-wrapper').addClass('d-none');
  }

  function toggleLocationFields(roleName) {
    hideAllLocationFields();
    if (!roleName) return;

    if (roleName === 'state_coordinator') {
      $('#state-wrapper').removeClass('d-none');
    }
    if (roleName === 'zonal_coordinator') {
      $('#state-wrapper, #zone-wrapper').removeClass('d-none');
    }
    if (roleName === 'lga_coordinator') {
      $('#state-wrapper, #zone-wrapper, #lga-wrapper').removeClass('d-none');
    }
    if (roleName === 'ward_coordinator') {
      $('#state-wrapper, #zone-wrapper, #lga-wrapper, #ward-wrapper').removeClass('d-none');
    }
  }

  // ── STATE CHANGE ─────────────────────────────────────────
  $('#state').on('change', function () {
    const stateId = $(this).val();
    $('#zone').html('<option value="">Select zone</option>');
    $('#lga').html('<option value="">Select LGA</option>');
    $('#ward').html('<option value="">Select Ward</option>');
    if (!stateId) return;

    $.get(`/admin/states/${stateId}`, function (data) {
      let options = '<option value="">Select zone</option>';
      data.state.zones.forEach(z => {
        options += `<option value="${z.id}">${z.name}</option>`;
      });
      $('#zone').html(options);
    });
  });

  // ── ZONE CHANGE ──────────────────────────────────────────
  $('#zone').on('change', function () {
    const zoneId = $(this).val();
    $('#lga').html('<option value="">Select LGA</option>');
    $('#ward').html('<option value="">Select Ward</option>');
    if (!zoneId) return;

    $.get(`/admin/zones/${zoneId}`, function (data) {
      let options = '<option value="">Select LGA</option>';
      data.zone.lgas.forEach(l => {
        options += `<option value="${l.id}">${l.name}</option>`;
      });
      $('#lga').html(options);
    });
  });

  // ── LGA CHANGE ───────────────────────────────────────────
  $('#lga').on('change', function () {
    const lgaId = $(this).val();
    $('#ward').html('<option value="">Select Ward</option>');
    if (!lgaId) return;

    $.get(`/admin/lgas/${lgaId}`, function (data) {
      let options = '<option value="">Select Ward</option>';
      data.lga.wards.forEach(w => {
        options += `<option value="${w.id}">${w.name}</option>`;
      });
      $('#ward').html(options);
    });
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#user-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/cvr/logins';

    if (editingId) {
      url = `/admin/cvr/logins/${editingId}`;
      formData.append('_method', 'PUT');
    }

    $.ajax({
      type: 'POST',
      url,
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: handleResponse,
      error: function (xhr) {
        if (xhr.status === 422) handleResponse(xhr.responseJSON);
        else toastr.error('Something went wrong', 'Error');
      }
    });
  });

  // ── DELETE ───────────────────────────────────────────────
  $(document).on('click', '.delete-user-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This user will be permanently deleted.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
    }).then((result) => {
      if (!result.isConfirmed) return;

      $.ajax({
        type: 'POST',
        url: `/admin/cvr/logins/${id}`,
        data: { _method: 'DELETE' },
        dataType: 'json',
        success: function (response) {
          if (response.status) {
            toastr.success(response.message, 'Deleted');
            refreshTable();
          } else {
            toastr.error(response.message || 'Could not delete.', 'Error');
          }
        },
        error: function () { toastr.error('Something went wrong', 'Error'); }
      });
    });
  });

  // ── RESPONSE HANDLER ─────────────────────────────────────
  function handleResponse(response) {
    const errors = response.errors || {};
    clearErrors();

    $.each(errors, function (field, messages) {
      $(`#${field}`).addClass('is-invalid');
      $(`#${field}-error`).text(messages[0]).show();
    });

    if (response.status) {
      cvrModal.hide();
      toastr.success(response.message, 'Success');
      refreshTable();
    }
  }

  // ── HELPERS ──────────────────────────────────────────────
  function clearErrors() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('').hide();
  }

  function refreshTable() {
    $('#cvr-table-container').load(location.href + ' #cvr-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection