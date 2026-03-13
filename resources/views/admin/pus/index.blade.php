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
      <h1>Polling Units Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Polling Units</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">Polling Units List</h5>
                <button id="create-pu-btn" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Add New PU
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all Polling Units in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="pus-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>Number</th>
                      <th>Name</th>
                      <th>State</th>
                      <th>Zone</th>
                      <th>LGA</th>
                      <th>Ward</th>
                      <th>Voters</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pus as $pu)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-primary">{{ $pu->number }}</td>
                        <td class="fw-semibold text-dark">{{ $pu->name }}</td>
                        <td><span class="badge bg-secondary rounded-pill">{{ $pu->state?->name }}</span></td>
                        <td><span class="badge bg-primary rounded-pill">{{ $pu->zone?->name }}</span></td>
                        <td><span class="badge bg-success rounded-pill">{{ $pu->lga?->name }}</span></td>
                        <td><span class="badge bg-info rounded-pill">{{ $pu->ward?->name }}</span></td>
                        <td><span class="badge bg-danger rounded-pill">{{ count($pu->users) }}</span></td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary view-pu-btn"
                              title="View"
                              data-id="{{ $pu->id }}">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success edit-pu-btn"
                              title="Edit"
                              data-id="{{ $pu->id }}"
                              data-number="{{ $pu->number }}"
                              data-name="{{ $pu->name }}"
                              data-state_id="{{ $pu->state_id ?? '' }}"
                              data-zone_id="{{ $pu->zone_id ?? '' }}"
                              data-lga_id="{{ $pu->lga_id ?? '' }}"
                              data-ward_id="{{ $pu->ward_id ?? '' }}"
                              data-description="{{ $pu->description ?? '' }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-pu-btn"
                              title="Delete"
                              data-id="{{ $pu->id }}">
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
                  Showing {{ $pus->firstItem() ?? 0 }} to {{ $pus->lastItem() ?? 0 }} of {{ $pus->total() }} entries
                </div>
                <div>{{ $pus->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.pus.modal')

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

  const puModalEl   = document.getElementById('pu-modal');
  const puModal     = new bootstrap.Modal(puModalEl);
  const viewModalEl = document.getElementById('pu-view-modal');
  const viewModal   = new bootstrap.Modal(viewModalEl);
  let editingId     = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    puModal.hide();
  });

  // ── RESET ON CLOSE (edit/create modal) ───────────────────
  puModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#pu-form')[0].reset();
    $('#zone_id').html('<option value="">Select Zone</option>');
    $('#lga_id').html('<option value="">Select LGA</option>');
    $('#ward_id').html('<option value="">Select Ward</option>');
    clearErrors();
    const focused = document.activeElement;
    if (focused && puModalEl.contains(focused)) focused.blur();
    $('#create-pu-btn').trigger('focus');
  });

  // ── RESET ON CLOSE (view modal) ──────────────────────────
  viewModalEl.addEventListener('hidden.bs.modal', function () {
    $('#view-pu-number, #view-pu-name, #view-pu-state, #view-pu-zone, #view-pu-lga, #view-pu-ward, #view-pu-description').text('—');
    const focused = document.activeElement;
    if (focused && viewModalEl.contains(focused)) focused.blur();
    $('#create-pu-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-pu-btn').on('click', function () {
    editingId = null;
    $('#pu-modal-title').text('Create Polling Unit');
    $('#pu-submit-btn').text('Save PU');
    clearErrors();
    puModal.show();
  });

  // ── OPEN FOR VIEW ────────────────────────────────────────
  $(document).on('click', '.view-pu-btn', function () {
    const id = $(this).data('id');

    $('#view-pu-name').text('Loading...');
    $('#view-pu-number, #view-pu-state, #view-pu-zone, #view-pu-lga, #view-pu-ward, #view-pu-description').text('—');
    viewModal.show();

    $.get(`/admin/pus/${id}`, function (data) {
      const pu = data.pu;
      $('#view-pu-number').text(pu.number);
      $('#view-pu-name').text(pu.name);
      $('#view-pu-state').text(pu.state?.name ?? '—');
      $('#view-pu-zone').text(pu.zone?.name ?? '—');
      $('#view-pu-lga').text(pu.lga?.name ?? '—');
      $('#view-pu-ward').text(pu.ward?.name ?? '—');
      $('#view-pu-description').text(pu.description || '—');
    }).fail(function () {
      toastr.error('Could not load polling unit details', 'Error');
      viewModal.hide();
    });
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-pu-btn', function () {
    const btn     = $(this);
    editingId     = btn.data('id');
    const stateId = btn.data('state_id');
    const zoneId  = btn.data('zone_id');
    const lgaId   = btn.data('lga_id');
    const wardId  = btn.data('ward_id');

    $('#pu-modal-title').text('Edit Polling Unit');
    $('#pu-submit-btn').text('Update PU');
    clearErrors();

    $('#number').val(btn.data('number'));
    $('#name').val(btn.data('name'));
    $('#description').val(btn.data('description'));
    $('#state_id').val(stateId);
    loadZones(stateId, zoneId);
    loadLgas(zoneId, lgaId);
    loadWards(lgaId, wardId);

    puModal.show();
  });

  // ── CASCADE CHANGES ──────────────────────────────────────
  $('#state_id').on('change', function () {
    loadZones($(this).val(), null);
    $('#lga_id').html('<option value="">Select LGA</option>');
    $('#ward_id').html('<option value="">Select Ward</option>');
  });

  $('#zone_id').on('change', function () {
    loadLgas($(this).val(), null);
    $('#ward_id').html('<option value="">Select Ward</option>');
  });

  $('#lga_id').on('change', function () {
    loadWards($(this).val(), null);
  });

  function loadZones(stateId, selectedId = null) {
    const items = window.puZonesData[stateId] || [];
    let options = '<option value="">Select Zone</option>';
    items.forEach(i => {
      options += `<option value="${i.id}" ${i.id == selectedId ? 'selected' : ''}>${i.name}</option>`;
    });
    $('#zone_id').html(options);
  }

  function loadLgas(zoneId, selectedId = null) {
    const items = window.puLgasData[zoneId] || [];
    let options = '<option value="">Select LGA</option>';
    items.forEach(i => {
      options += `<option value="${i.id}" ${i.id == selectedId ? 'selected' : ''}>${i.name}</option>`;
    });
    $('#lga_id').html(options);
  }

  function loadWards(lgaId, selectedId = null) {
    const items = window.puWardsData[lgaId] || [];
    let options = '<option value="">Select Ward</option>';
    items.forEach(i => {
      options += `<option value="${i.id}" ${i.id == selectedId ? 'selected' : ''}>${i.name}</option>`;
    });
    $('#ward_id').html(options);
  }

  // ── SUBMIT (create or update) ────────────────────────────
  $('#pu-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/pus';

    if (editingId) {
      url = `/admin/pus/${editingId}`;
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
  $(document).on('click', '.delete-pu-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This polling unit will be permanently deleted.',
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
        url: `/admin/pus/${id}`,
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
      puModal.hide();
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
    $('#pus-table-container').load(location.href + ' #pus-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection