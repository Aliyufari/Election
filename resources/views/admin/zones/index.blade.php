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
      <h1>Zones Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Zones</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">Zones List</h5>
                <button id="create-zone-btn" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Add New Zone
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all zones in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="zones-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>Name</th>
                      <th>State</th>
                      <th>LGAs</th>
                      <th>Wards</th>
                      <th>PUs</th>
                      <th>Voters</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($zones as $zone)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-dark">{{ $zone->name }}</td>
                        <td>
                          <span class="badge bg-secondary rounded-pill">{{ $zone->state?->name ?? 'N/A' }}</span>
                        </td>
                        <td><span class="badge bg-success rounded-pill">{{ count($zone->lgas) }}</span></td>
                        <td><span class="badge bg-info rounded-pill">{{ count($zone->wards) }}</span></td>
                        <td><span class="badge bg-warning rounded-pill">{{ count($zone->pus) }}</span></td>
                        <td><span class="badge bg-danger rounded-pill">{{ count($zone->users) }}</span></td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary view-zone-btn"
                              title="View"
                              data-id="{{ $zone->id }}">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success edit-zone-btn"
                              title="Edit"
                              data-id="{{ $zone->id }}"
                              data-name="{{ $zone->name }}"
                              data-state_id="{{ $zone->state_id ?? '' }}"
                              data-description="{{ $zone->description ?? '' }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-zone-btn"
                              title="Delete"
                              data-id="{{ $zone->id }}">
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
                  Showing {{ $zones->firstItem() ?? 0 }} to {{ $zones->lastItem() ?? 0 }} of {{ $zones->total() }} entries
                </div>
                <div>{{ $zones->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.zones.modal')

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

  const zoneModalEl = document.getElementById('zone-modal');
  const zoneModal   = new bootstrap.Modal(zoneModalEl);
  const viewModalEl = document.getElementById('zone-view-modal');
  const viewModal   = new bootstrap.Modal(viewModalEl);
  let editingId     = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    zoneModal.hide();
  });

  // ── RESET ON CLOSE ───────────────────────────────────────
  zoneModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#zone-form')[0].reset();
    clearErrors();

    const focused = document.activeElement;
    if (focused && zoneModalEl.contains(focused)) focused.blur();
    $('#create-zone-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-zone-btn').on('click', function () {
    editingId = null;
    $('#zone-modal-title').text('Create Zone');
    $('#zone-submit-btn').text('Save Zone');
    clearErrors();
    zoneModal.show();
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-zone-btn', function () {
    const btn = $(this);
    editingId = btn.data('id');

    $('#zone-modal-title').text('Edit Zone');
    $('#zone-submit-btn').text('Update Zone');
    clearErrors();

    $('#name').val(btn.data('name'));
    $('#state_id').val(btn.data('state_id'));
    $('#description').val(btn.data('description'));

    zoneModal.show();
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#zone-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/zones';

    if (editingId) {
      url = `/admin/zones/${editingId}`;
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

  viewModalEl.addEventListener('hidden.bs.modal', function () {
    $('#view-zone-name, #view-zone-state, #view-zone-description').text('—');
    const focused = document.activeElement;
    if (focused && viewModalEl.contains(focused)) focused.blur();
    $('#create-zone-btn').trigger('focus');
  });

  // ── OPEN FOR VIEW ────────────────────────────────────────
  $(document).on('click', '.view-zone-btn', function () {
    const id = $(this).data('id');

    $('#view-zone-name').text('Loading...');
    $('#view-zone-state, #view-zone-description').text('—');
    viewModal.show();

    $.get(`/admin/zones/${id}`, function (data) {
      const zone = data.zone;
      $('#view-zone-name').text(zone.name);
      $('#view-zone-state').text(zone.state?.name ?? '—');
      $('#view-zone-description').text(zone.description || '—');
    }).fail(function () {
      toastr.error('Could not load zone details', 'Error');
      viewModal.hide();
    });
  });

  // ── DELETE ───────────────────────────────────────────────
  $(document).on('click', '.delete-zone-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This zone will be permanently deleted.',
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
        url: `/admin/zones/${id}`,
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
      zoneModal.hide();
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
    $('#zones-table-container').load(location.href + ' #zones-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection