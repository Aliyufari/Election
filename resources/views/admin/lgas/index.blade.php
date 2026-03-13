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
      <h1>LGAs Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">LGAs</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">LGAs List</h5>
                <button id="create-lga-btn" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Add New LGA
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all Local Government Areas in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="lgas-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>Name</th>
                      <th>State</th>
                      <th>Zone</th>
                      <th>Wards</th>
                      <th>PUs</th>
                      <th>Voters</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lgas as $lga)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-dark">{{ $lga->name }}</td>
                        <td>
                          <span class="badge bg-secondary rounded-pill">{{ $lga->state->name }}</span>
                        </td>
                        <td>
                          <span class="badge bg-primary rounded-pill">{{ $lga->zone->name }}</span>
                        </td>
                        <td><span class="badge bg-info rounded-pill">{{ count($lga->wards) }}</span></td>
                        <td><span class="badge bg-warning rounded-pill">{{ count($lga->pus) }}</span></td>
                        <td><span class="badge bg-danger rounded-pill">{{ count($lga->users) }}</span></td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary view-lga-btn"
                              title="View"
                              data-id="{{ $lga->id }}">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success edit-lga-btn"
                              title="Edit"
                              data-id="{{ $lga->id }}"
                              data-name="{{ $lga->name }}"
                              data-state_id="{{ $lga->state_id ?? '' }}"
                              data-zone_id="{{ $lga->zone_id ?? '' }}"
                              data-description="{{ $lga->description ?? '' }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-lga-btn"
                              title="Delete"
                              data-id="{{ $lga->id }}">
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
                  Showing {{ $lgas->firstItem() ?? 0 }} to {{ $lgas->lastItem() ?? 0 }} of {{ $lgas->total() }} entries
                </div>
                <div>{{ $lgas->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.lgas.modal')

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

  // ── MODALS ───────────────────────────────────────────────
  const lgaModalEl  = document.getElementById('lga-modal');
  const lgaModal    = new bootstrap.Modal(lgaModalEl);
  const viewModalEl = document.getElementById('lga-view-modal');
  const viewModal   = new bootstrap.Modal(viewModalEl);
  let editingId     = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    lgaModal.hide();
  });

  // ── RESET ON CLOSE (edit/create modal) ───────────────────
  lgaModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#lga-form')[0].reset();
    $('#zone_id').html('<option value="">Select Zone</option>');
    clearErrors();

    const focused = document.activeElement;
    if (focused && lgaModalEl.contains(focused)) focused.blur();
    $('#create-lga-btn').trigger('focus');
  });

  // ── RESET ON CLOSE (view modal) ──────────────────────────
  viewModalEl.addEventListener('hidden.bs.modal', function () {
    $('#view-lga-name, #view-lga-state, #view-lga-zone, #view-lga-description, #view-lga-wards').text('—');
    const focused = document.activeElement;
    if (focused && viewModalEl.contains(focused)) focused.blur();
    $('#create-lga-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-lga-btn').on('click', function () {
    editingId = null;
    $('#lga-modal-title').text('Create LGA');
    $('#lga-submit-btn').text('Save LGA');
    clearErrors();
    lgaModal.show();
  });

  // ── OPEN FOR VIEW ────────────────────────────────────────
  $(document).on('click', '.view-lga-btn', function () {
    const id = $(this).data('id');

    $('#view-lga-name').text('Loading...');
    $('#view-lga-state, #view-lga-zone, #view-lga-description, #view-lga-wards').text('—');
    viewModal.show();

    $.get(`/admin/lgas/${id}`, function (data) {
      const lga = data.lga;
      $('#view-lga-name').text(lga.name);
      $('#view-lga-state').text(lga.state?.name ?? '—');
      $('#view-lga-zone').text(lga.zone?.name ?? '—');
      $('#view-lga-description').text(lga.description || '—');
      $('#view-lga-wards').text(
        lga.wards?.length ? lga.wards.map(w => w.name).join(', ') : '—'
      );
    }).fail(function () {
      toastr.error('Could not load LGA details', 'Error');
      viewModal.hide();
    });
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-lga-btn', function () {
    const btn     = $(this);
    editingId     = btn.data('id');
    const stateId = btn.data('state_id');
    const zoneId  = btn.data('zone_id');

    $('#lga-modal-title').text('Edit LGA');
    $('#lga-submit-btn').text('Update LGA');
    clearErrors();

    $('#name').val(btn.data('name'));
    $('#description').val(btn.data('description'));
    $('#state_id').val(stateId);
    loadZones(stateId, zoneId);

    lgaModal.show();
  });

  // ── STATE CHANGE ─────────────────────────────────────────
  $('#state_id').on('change', function () {
    loadZones($(this).val(), null);
  });

  function loadZones(stateId, selectedZoneId = null) {
    const zones = (window.zonesData[stateId] || []);
    let options = '<option value="">Select Zone</option>';
    zones.forEach(z => {
      const sel = z.id == selectedZoneId ? 'selected' : '';
      options += `<option value="${z.id}" ${sel}>${z.name}</option>`;
    });
    $('#zone_id').html(options);
  }

  // ── SUBMIT (create or update) ────────────────────────────
  $('#lga-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/lgas';

    if (editingId) {
      url = `/admin/lgas/${editingId}`;
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
  $(document).on('click', '.delete-lga-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This LGA will be permanently deleted.',
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
        url: `/admin/lgas/${id}`,
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
      lgaModal.hide();
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
    $('#lgas-table-container').load(location.href + ' #lgas-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection