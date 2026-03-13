@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.admin.sidebar')
@endsection

@section('content')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Wards Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Wards</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">Wards List</h5>
                <button id="create-ward-btn" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Add New Ward
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all wards in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="wards-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>Name</th>
                      <th>State</th>
                      <th>Zone</th>
                      <th>LGA</th>
                      <th>PUs</th>
                      <th>Voters</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($wards as $ward)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-dark">{{ $ward->name }}</td>
                        <td><span class="badge bg-secondary rounded-pill">{{ $ward->state->name }}</span></td>
                        <td><span class="badge bg-primary rounded-pill">{{ $ward->zone->name }}</span></td>
                        <td><span class="badge bg-success rounded-pill">{{ $ward->lga->name }}</span></td>
                        <td><span class="badge bg-warning rounded-pill">{{ count($ward->pus) }}</span></td>
                        <td><span class="badge bg-danger rounded-pill">{{ count($ward->users) }}</span></td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary view-ward-btn"
                              title="View"
                              data-id="{{ $ward->id }}">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success edit-ward-btn"
                              title="Edit"
                              data-id="{{ $ward->id }}"
                              data-name="{{ $ward->name }}"
                              data-state_id="{{ $ward->state_id ?? '' }}"
                              data-zone_id="{{ $ward->zone_id ?? '' }}"
                              data-lga_id="{{ $ward->lga_id ?? '' }}"
                              data-description="{{ $ward->description ?? '' }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-ward-btn"
                              title="Delete"
                              data-id="{{ $ward->id }}">
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
                  Showing {{ $wards->firstItem() ?? 0 }} to {{ $wards->lastItem() ?? 0 }} of {{ $wards->total() }} entries
                </div>
                <div>{{ $wards->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.wards.modal')

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

  const wardModalEl = document.getElementById('ward-modal');
  const wardModal   = new bootstrap.Modal(wardModalEl);
  const viewModalEl = document.getElementById('ward-view-modal');
  const viewModal   = new bootstrap.Modal(viewModalEl);
  let editingId     = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    wardModal.hide();
  });

  // ── RESET ON CLOSE (edit/create modal) ───────────────────
  wardModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#ward-form')[0].reset();
    $('#zone_id').html('<option value="">Select Zone</option>');
    $('#lga_id').html('<option value="">Select LGA</option>');
    clearErrors();
    const focused = document.activeElement;
    if (focused && wardModalEl.contains(focused)) focused.blur();
    $('#create-ward-btn').trigger('focus');
  });

  // ── RESET ON CLOSE (view modal) ──────────────────────────
  viewModalEl.addEventListener('hidden.bs.modal', function () {
    $('#view-ward-name, #view-ward-state, #view-ward-zone, #view-ward-lga, #view-ward-description').text('—');
    const focused = document.activeElement;
    if (focused && viewModalEl.contains(focused)) focused.blur();
    $('#create-ward-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-ward-btn').on('click', function () {
    editingId = null;
    $('#ward-modal-title').text('Create Ward');
    $('#ward-submit-btn').text('Save Ward');
    clearErrors();
    wardModal.show();
  });

  // ── OPEN FOR VIEW ────────────────────────────────────────
  $(document).on('click', '.view-ward-btn', function () {
    const id = $(this).data('id');

    $('#view-ward-name').text('Loading...');
    $('#view-ward-state, #view-ward-zone, #view-ward-lga, #view-ward-description').text('—');
    viewModal.show();

    $.get(`/admin/wards/${id}`, function (data) {
      const ward = data.ward;
      $('#view-ward-name').text(ward.name);
      $('#view-ward-state').text(ward.state?.name ?? '—');
      $('#view-ward-zone').text(ward.zone?.name ?? '—');
      $('#view-ward-lga').text(ward.lga?.name ?? '—');
      $('#view-ward-description').text(ward.description || '—');
    }).fail(function () {
      toastr.error('Could not load ward details', 'Error');
      viewModal.hide();
    });
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-ward-btn', function () {
    const btn     = $(this);
    editingId     = btn.data('id');
    const stateId = btn.data('state_id');
    const zoneId  = btn.data('zone_id');
    const lgaId   = btn.data('lga_id');

    $('#ward-modal-title').text('Edit Ward');
    $('#ward-submit-btn').text('Update Ward');
    clearErrors();

    $('#name').val(btn.data('name'));
    $('#description').val(btn.data('description'));
    $('#state_id').val(stateId);
    loadZones(stateId, zoneId);
    loadLgas(zoneId, lgaId);

    wardModal.show();
  });

  // ── STATE CHANGE ─────────────────────────────────────────
  $('#state_id').on('change', function () {
    loadZones($(this).val(), null);
    $('#lga_id').html('<option value="">Select LGA</option>');
  });

  // ── ZONE CHANGE ──────────────────────────────────────────
  $('#zone_id').on('change', function () {
    loadLgas($(this).val(), null);
  });

  function loadZones(stateId, selectedZoneId = null) {
    const zones = window.wardZonesData[stateId] || [];
    let options = '<option value="">Select Zone</option>';
    zones.forEach(z => {
      const sel = z.id == selectedZoneId ? 'selected' : '';
      options += `<option value="${z.id}" ${sel}>${z.name}</option>`;
    });
    $('#zone_id').html(options);
  }

  function loadLgas(zoneId, selectedLgaId = null) {
    const lgas = window.wardLgasData[zoneId] || [];
    let options = '<option value="">Select LGA</option>';
    lgas.forEach(l => {
      const sel = l.id == selectedLgaId ? 'selected' : '';
      options += `<option value="${l.id}" ${sel}>${l.name}</option>`;
    });
    $('#lga_id').html(options);
  }

  // ── SUBMIT (create or update) ────────────────────────────
  $('#ward-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/wards';

    if (editingId) {
      url = `/admin/wards/${editingId}`;
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
  $(document).on('click', '.delete-ward-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This ward will be permanently deleted.',
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
        url: `/admin/wards/${id}`,
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
    clearErrors();
    const errors = response.errors || {};

    $.each(errors, function (field, messages) {
      $(`#${field}`).addClass('is-invalid');
      $(`#${field}-error`).text(messages[0]).show();
    });

    if (response.status) {
      wardModal.hide();
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
    $('#wards-table-container').load(location.href + ' #wards-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection