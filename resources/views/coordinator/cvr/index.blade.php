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

          <div class="card-body pt-3">
            <div class="table-responsive" id="cvr-table-container">
              <table class="table table-hover table-borderless">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Ward</th>
                    <th>PU</th>
                    <th>Status</th>
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
                      <td><span class="badge bg-success rounded-pill">{{ $cvr->pu?->ward?->name ?? 'N/A' }}</span></td>
                      <td><span class="badge bg-info rounded-pill">{{ $cvr->pu?->name ?? 'N/A' }}</span></td>
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
                      <td class="text-muted small">{{ $cvr->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</td>
                      <td class="text-muted small">{{ $cvr->updated_at?->format('d M Y, h:i A') ?? 'N/A' }}</td>
                      <td class="text-center pe-3">
                        <div class="btn-group" role="group">
                          <a href="/coordinator/cvrs/{{ $cvr->id }}" class="btn btn-sm btn-outline-primary" title="View">
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

@include('coordinator.cvr.add-cvr-modal')

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

  // ── EMBEDDED DATA — no AJAX needed ───────────────────────
  const zonesData = @json($states->mapWithKeys(fn($s) => [
    $s->id => $s->zones->map(fn($z) => ['id' => $z->id, 'name' => $z->name])
  ]));
  const lgasData = @json($states->flatMap(fn($s) => $s->zones)->mapWithKeys(fn($z) => [
    $z->id => $z->lgas->map(fn($l) => ['id' => $l->id, 'name' => $l->name])
  ]));
  const wardsData = @json($states->flatMap(fn($s) => $s->zones)->flatMap(fn($z) => $z->lgas)->mapWithKeys(fn($l) => [
    $l->id => $l->wards->map(fn($w) => ['id' => $w->id, 'name' => $w->name])
  ]));
  const pusData = @json($states->flatMap(fn($s) => $s->zones)->flatMap(fn($z) => $z->lgas)->flatMap(fn($l) => $l->wards)->mapWithKeys(fn($w) => [
    $w->id => $w->pus->map(fn($p) => ['id' => $p->id, 'name' => ($p->number . ($p->name ? ' - ' . $p->name : ''))])
  ]));

  // Coordinator's own location scope
  const coord = {
    state_id: {{ $coordinator->state_id ?? 'null' }},
    zone_id:  {{ $coordinator->zone_id  ?? 'null' }},
    lga_id:   {{ $coordinator->lga_id   ?? 'null' }},
    ward_id:  {{ $coordinator->ward_id  ?? 'null' }},
  };

  const cvrModalEl = document.getElementById('cvr-modal');
  const cvrModal   = new bootstrap.Modal(cvrModalEl);
  let editingId    = null;

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
    clearErrors();

    // Pre-fill from coordinator's scope using embedded data
    if (coord.state_id) {
      $('#state').val(coord.state_id);
      populateSelect('#zone', zonesData[coord.state_id] || [], 'Select zone', coord.zone_id);
    }
    if (coord.zone_id) {
      populateSelect('#lga', lgasData[coord.zone_id] || [], 'Select LGA', coord.lga_id);
    }
    if (coord.lga_id) {
      populateSelect('#ward', wardsData[coord.lga_id] || [], 'Select ward', coord.ward_id);
    }
    if (coord.ward_id) {
      populateSelect('#pu', pusData[coord.ward_id] || [], 'Select PU');
    }

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
    $('#state').val(stateId);

    populateSelect('#zone', zonesData[stateId] || [], 'Select zone', zoneId);
    populateSelect('#lga',  lgasData[zoneId]   || [], 'Select LGA',  lgaId);
    populateSelect('#ward', wardsData[lgaId]   || [], 'Select ward', wardId);
    populateSelect('#pu',   pusData[wardId]    || [], 'Select PU',   puId);

    cvrModal.show();
  });

  // ── MODAL CASCADING SELECTS ──────────────────────────────
  $('#state').on('change', function () {
    const id = $(this).val();
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    if (id) populateSelect('#zone', zonesData[id] || [], 'Select zone');
  });

  $('#zone').on('change', function () {
    const id = $(this).val();
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    if (id) populateSelect('#lga', lgasData[id] || [], 'Select LGA');
  });

  $('#lga').on('change', function () {
    const id = $(this).val();
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    if (id) populateSelect('#ward', wardsData[id] || [], 'Select ward');
  });

  $('#ward').on('change', function () {
    const id = $(this).val();
    resetSelect('#pu', 'Select PU');
    if (id) populateSelect('#pu', pusData[id] || [], 'Select PU');
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#cvr-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/coordinator/cvrs';

    if (editingId) {
      url = `/coordinator/cvrs/${editingId}`;
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
        url: `/coordinator/cvrs/${id}`,
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

@section('toast')
  @include('partials.toast')
@endsection