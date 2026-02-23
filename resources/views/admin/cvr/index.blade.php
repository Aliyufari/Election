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
    <h1>CVR Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">CVRs</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <div class="col-12">
        <div class="card recent-sales overflow-auto border-0 shadow-sm">

          <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0 text-dark fw-bold">CVR List</h5>
              <button type="button" id="create-cvr-btn" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Add New CVR
              </button>
            </div>
            <p class="text-muted mt-2 mb-0">Manage all CVRs in the system</p>
          </div>

          <!-- Filters -->
          <div class="card-body pb-0">
            <form method="GET" action="/admin/cvr/records" id="filter-form">
              <div class="row g-2 align-items-end">

                <div class="col-md-2">
                  <label class="form-label small">State</label>
                  <select class="form-select form-select-sm" name="state_id" id="filter-state">
                    <option value="">All States</option>
                    @foreach($states as $state)
                      <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-2">
                  <label class="form-label small">Zone</label>
                  <select class="form-select form-select-sm" name="zone_id" id="filter-zone">
                    <option value="">All Zones</option>
                    @foreach($zones as $zone)
                      <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                        {{ $zone->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-2">
                  <label class="form-label small">LGA</label>
                  <select class="form-select form-select-sm" name="lga_id" id="filter-lga">
                    <option value="">All LGAs</option>
                    @foreach($lgas as $lga)
                      <option value="{{ $lga->id }}" {{ request('lga_id') == $lga->id ? 'selected' : '' }}>
                        {{ $lga->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-2">
                  <label class="form-label small">Ward</label>
                  <select class="form-select form-select-sm" name="ward_id" id="filter-ward">
                    <option value="">All Wards</option>
                    @foreach($wards as $ward)
                      <option value="{{ $ward->id }}" {{ request('ward_id') == $ward->id ? 'selected' : '' }}>
                        {{ $ward->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-1">
                  <label class="form-label small">Type</label>
                  <select class="form-select form-select-sm" name="type">
                    <option value="">All</option>
                    <option value="registration" {{ request('type') === 'registration' ? 'selected' : '' }}>Registration</option>
                    <option value="transfer"     {{ request('type') === 'transfer'     ? 'selected' : '' }}>Transfer</option>
                    <option value="update"       {{ request('type') === 'update'       ? 'selected' : '' }}>Update</option>
                  </select>
                </div>

                <div class="col-md-1">
                  <label class="form-label small">Status</label>
                  <select class="form-select form-select-sm" name="status">
                    <option value="">All</option>
                    <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                  </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                  <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                  </button>
                  <a href="/admin/cvr/records" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-x-circle me-1"></i>Reset
                  </a>
                </div>

              </div>
            </form>
          </div>

          <div class="card-body pt-3">
            <div class="table-responsive" id="cvr-table-container">
              <table class="table table-hover table-borderless">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>State</th>
                    <th>Zone</th>
                    <th>LGA</th>
                    <th>Ward</th>
                    <th>PU</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Date Created</th>
                    <th>Date Updated</th>
                    <th class="text-center pe-3">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cvrs as $cvr)
                    <tr class="border-bottom">
                      <td class="fw-semibold text-dark">{{ $cvr->unique_id }}</td>
                      <td><span class="badge bg-secondary rounded-pill">{{ $cvr->type }}</span></td>
                      <td>
                        @if($cvr->pu?->ward?->lga?->zone?->state)
                          <span class="badge bg-dark rounded-pill">{{ $cvr->pu->ward->lga->zone->state->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        @if($cvr->pu?->ward?->lga?->zone)
                          <span class="badge bg-warning rounded-pill">{{ $cvr->pu->ward->lga->zone->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        @if($cvr->pu?->ward?->lga)
                          <span class="badge bg-info rounded-pill">{{ $cvr->pu->ward->lga->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        @if($cvr->pu?->ward)
                          <span class="badge bg-success rounded-pill">{{ $cvr->pu->ward->name }}</span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td><span class="badge bg-primary rounded-pill">{{ $cvr->pu?->name ?? '-' }}</span></td>
                      <td>
                        @php
                          $statusColor = match($cvr->status) {
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default    => 'warning',
                          };
                        @endphp
                        <span class="badge bg-{{ $statusColor }} rounded-pill">{{ $cvr->status }}</span>
                      </td>
                      <td class="text-muted small">{{ $cvr->createdBy?->name ?? 'N/A' }}</td>
                      <td class="text-muted small">{{ $cvr->updatedBy?->name ?? 'N/A' }}</td>
                      <td class="text-muted small">{{ $cvr->created_at?->format('d M Y, h:i A') ?? '' }}</td>
                      <td class="text-muted small">{{ $cvr->updated_at?->format('d M Y, h:i A') ?? '' }}</td>
                      <td class="text-center pe-3">
                        <div class="btn-group" role="group">
                          <a href="/admin/cvrs/{{ $cvr->id }}" class="btn btn-sm btn-outline-primary" title="View">
                            <i class="bi bi-eye"></i>
                          </a>
                          <a href="#" class="btn btn-sm btn-outline-success edit-cvr-btn"
                            title="Edit"
                            data-id="{{ $cvr->id }}"
                            data-unique_id="{{ $cvr->unique_id }}"
                            data-type="{{ $cvr->type }}"
                            data-state_id="{{ $cvr->pu?->ward?->lga?->zone?->state_id ?? '' }}"
                            data-zone_id="{{ $cvr->pu?->ward?->lga?->zone_id ?? '' }}"
                            data-lga_id="{{ $cvr->pu?->ward?->lga_id ?? '' }}"
                            data-ward_id="{{ $cvr->pu?->ward_id ?? '' }}"
                            data-pu_id="{{ $cvr->pu_id ?? '' }}"
                            data-status="{{ $cvr->status }}">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <button type="button" class="btn btn-sm btn-outline-danger delete-cvr-btn"
                            title="Delete"
                            data-id="{{ $cvr->id }}">
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
                Showing {{ $cvrs->firstItem() ?? 0 }} to {{ $cvrs->lastItem() ?? 0 }} of {{ $cvrs->total() }} entries
              </div>
              <div>{{ $cvrs->links() }}</div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>

</main>

<!-- CVR Modal -->
<div class="modal fade" id="cvr-modal" tabindex="-1" aria-labelledby="cvr-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-sm">

      <div class="modal-header">
        <h5 class="modal-title" id="cvr-modal-title">Create CVR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="cvr-form" novalidate>
          @csrf

          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">CVR Unique ID</label>
              <input type="text" class="form-control" id="unique_id" name="unique_id">
              <div class="invalid-feedback" id="unique_id-error"></div>
            </div>

            <div class="col-md-6">
              <label class="form-label">CVR Type</label>
              <select class="form-select" name="type" id="type">
                <option value="">Select type</option>
                <option value="registration">Registration</option>
                <option value="transfer">Transfer</option>
                <option value="update">Update</option>
              </select>
              <div class="invalid-feedback" id="type-error"></div>
            </div>

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

            <div class="col-md-4">
              <label class="form-label">Zone</label>
              <select class="form-select" id="zone" name="zone_id" disabled>
                <option value="">Select zone</option>
              </select>
              <div class="invalid-feedback" id="zone-error"></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">LGA</label>
              <select class="form-select" id="lga" name="lga_id" disabled>
                <option value="">Select LGA</option>
              </select>
              <div class="invalid-feedback" id="lga-error"></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Ward</label>
              <select class="form-select" id="ward" name="ward_id" disabled>
                <option value="">Select ward</option>
              </select>
              <div class="invalid-feedback" id="ward-error"></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Polling Unit</label>
              <select class="form-select" id="pu" name="pu_id" disabled>
                <option value="">Select PU</option>
              </select>
              <div class="invalid-feedback" id="pu-error"></div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select class="form-select" name="status" id="status">
                <option value="">Select status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </select>
              <div class="invalid-feedback" id="status-error"></div>
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" id="cvr-submit-btn">Save CVR</button>
            <button type="button" class="btn btn-secondary" id="cvr-cancel-btn">Cancel</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

<style>
  .table > :not(caption) > * > * { padding: 0.75rem 0.5rem; }
  .btn-group .btn { margin: 0 2px; }
  .table-hover tbody tr:hover { background-color: rgba(0,0,0,0.02); }
</style>
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

  // ── CANCEL BUTTON — fix aria-hidden warning ──────────────
  $('#cvr-cancel-btn').on('click', function () {
    $(this).blur();
    cvrModal.hide();
  });

  // ── RESET ON CLOSE ───────────────────────────────────────
  cvrModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#cvr-form')[0].reset();
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    clearErrors();
    const focused = document.activeElement;
    if (focused && cvrModalEl.contains(focused)) focused.blur();
    $('#create-cvr-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-cvr-btn').on('click', function () {
    editingId = null;
    $('#cvr-modal-title').text('Create CVR');
    $('#cvr-submit-btn').text('Save CVR');
    $('#cvr-form')[0].reset();
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    clearErrors();
    cvrModal.show();
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-cvr-btn', function () {
    const btn     = $(this);
    editingId     = btn.data('id');
    const stateId = btn.data('state_id');
    const zoneId  = btn.data('zone_id');
    const lgaId   = btn.data('lga_id');
    const wardId  = btn.data('ward_id');
    const puId    = btn.data('pu_id');

    $('#cvr-modal-title').text('Edit CVR');
    $('#cvr-submit-btn').text('Update CVR');
    clearErrors();

    $('#unique_id').val(btn.data('unique_id'));
    $('#type').val(btn.data('type'));
    $('#status').val(btn.data('status'));

    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');

    if (stateId) {
      $('#state').val(stateId);
      $.get(`/admin/states/${stateId}`, function (data) {
        populateSelect('#zone', data.state.zones, 'Select zone', zoneId);
        if (zoneId) {
          $.get(`/admin/zones/${zoneId}`, function (data) {
            populateSelect('#lga', data.zone.lgas, 'Select LGA', lgaId);
            if (lgaId) {
              $.get(`/admin/lgas/${lgaId}`, function (data) {
                populateSelect('#ward', data.lga.wards, 'Select ward', wardId);
                if (wardId) {
                  $.get(`/admin/wards/${wardId}`, function (data) {
                    populateSelect('#pu', data.ward.pus, 'Select PU', puId);
                  });
                }
              });
            }
          });
        }
      });
    }

    cvrModal.show();
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#cvr-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/cvrs';

    if (editingId) {
      url = `/admin/cvrs/${editingId}`;
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
  $(document).on('click', '.delete-cvr-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This CVR will be permanently deleted.',
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
        url: `/admin/cvrs/${id}`,
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
    const map = {
      unique_id: '#unique_id',
      type:      '#type',
      state_id:  '#state',
      zone_id:   '#zone',
      lga_id:    '#lga',
      ward_id:   '#ward',
      pu_id:     '#pu',
      status:    '#status',
    };

    clearErrors();

    $.each(map, function (key, selector) {
      if (errors[key]) {
        $(selector).addClass('is-invalid');
        $(`${selector}-error`).text(errors[key][0]).show();
      }
    });

    if (response.status) {
      cvrModal.hide();
      toastr.success(response.message, 'Success');
      refreshTable();
    }
  }

  // ── FILTER — cascading zone/lga/ward on filter bar ───────
  $('#filter-state').on('change', function () {
    const stateId = $(this).val();
    $('#filter-zone').html('<option value="">All Zones</option>');
    $('#filter-lga').html('<option value="">All LGAs</option>');
    $('#filter-ward').html('<option value="">All Wards</option>');
    if (!stateId) return;

    $.get(`/admin/states/${stateId}`, function (data) {
      data.state.zones.forEach(z => {
        $('#filter-zone').append(`<option value="${z.id}">${z.name}</option>`);
      });
    });
  });

  $('#filter-zone').on('change', function () {
    const zoneId = $(this).val();
    $('#filter-lga').html('<option value="">All LGAs</option>');
    $('#filter-ward').html('<option value="">All Wards</option>');
    if (!zoneId) return;

    $.get(`/admin/zones/${zoneId}`, function (data) {
      data.zone.lgas.forEach(l => {
        $('#filter-lga').append(`<option value="${l.id}">${l.name}</option>`);
      });
    });
  });

  $('#filter-lga').on('change', function () {
    const lgaId = $(this).val();
    $('#filter-ward').html('<option value="">All Wards</option>');
    if (!lgaId) return;

    $.get(`/admin/lgas/${lgaId}`, function (data) {
      data.lga.wards.forEach(w => {
        $('#filter-ward').append(`<option value="${w.id}">${w.name}</option>`);
      });
    });
  });

  // ── MODAL CASCADING SELECTS ──────────────────────────────
  $('#state').on('change', function () {
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/admin/states/${id}`, function (data) {
      populateSelect('#zone', data.state.zones, 'Select zone');
    });
  });

  $('#zone').on('change', function () {
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/admin/zones/${id}`, function (data) {
      populateSelect('#lga', data.zone.lgas, 'Select LGA');
    });
  });

  $('#lga').on('change', function () {
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/admin/lgas/${id}`, function (data) {
      populateSelect('#ward', data.lga.wards, 'Select ward');
    });
  });

  $('#ward').on('change', function () {
    resetSelect('#pu', 'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/admin/wards/${id}`, function (data) {
      populateSelect('#pu', data.ward.pus, 'Select PU');
    });
  });

  // ── HELPERS ──────────────────────────────────────────────
  function populateSelect(selector, items, label, selectedId = null) {
    let options = `<option value="">${label}</option>`;
    items.forEach(item => {
      const selected = selectedId && item.id == selectedId ? 'selected' : '';
      options += `<option value="${item.id}" ${selected}>${item.name}</option>`;
    });
    $(selector).html(options).prop('disabled', false);
  }

  function resetSelect(selector, label) {
    $(selector).html(`<option value="">${label}</option>`).prop('disabled', true);
  }

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

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection