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
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- CVR List -->
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
                      <td><span class="badge bg-warning rounded-pill">{{ $cvr->status }}</span></td>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div class="text-muted small">
                Showing {{ $cvrs->firstItem() ?? 0 }} to {{ $cvrs->lastItem() ?? 0 }} of {{ $cvrs->total() }} entries
              </div>
              <div>
                {{ $cvrs->links() }}
              </div>
            </div>

          </div>

        </div>
      </div><!-- End CVR List -->

    </div>
  </section>

</main><!-- End #main -->

@include('coordinator.cvr.add-cvr-modal')

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

@section('script')
<script>
$(document).ready(function () {

  const coordinatorData = {
    state_id: {{ $coordinator->state_id ?? 'null' }},
    zone_id:  {{ $coordinator->zone_id  ?? 'null' }},
    lga_id:   {{ $coordinator->lga_id   ?? 'null' }},
    ward_id:  {{ $coordinator->ward_id  ?? 'null' }},
  };

  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  const cvrModalEl = document.getElementById('cvr-modal');
  const cvrModal   = new bootstrap.Modal(cvrModalEl);
  let editingId    = null;

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-cvr-btn').on('click', function () {
    editingId = null;
    $('#cvr-modal-title').text('Create CVR');
    $('#cvr-submit-btn').text('Save CVR');
    $('#cvr-form')[0].reset();
    clearErrors();

    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');

    // Auto-populate from coordinator's own profile
    if (coordinatorData.state_id) {
      $('#state').val(coordinatorData.state_id);

      $.get(`/coordinator/states/${coordinatorData.state_id}`, function (data) {
        populateSelect('#zone', data.state.zones, 'Select zone', coordinatorData.zone_id);

        // Helper: load wards for a given lga_id
        const loadWards = function (lgaId) {
          $.get(`/coordinator/lgas/${lgaId}`, function (data) {
            populateSelect('#ward', data.lga.wards, 'Select ward', coordinatorData.ward_id);

            if (coordinatorData.ward_id) {
              $.get(`/coordinator/wards/${coordinatorData.ward_id}`, function (data) {
                populateSelect('#pu', data.ward.pus, 'Select PU');
              });
            }
          });
        };

        // Helper: load LGAs for a given zone_id, then continue to wards
        const loadLgas = function (zoneId) {
          $.get(`/coordinator/zones/${zoneId}`, function (data) {
            populateSelect('#lga', data.zone.lgas, 'Select LGA', coordinatorData.lga_id);

            if (coordinatorData.lga_id) {
              loadWards(coordinatorData.lga_id);
            }
          });
        };

        if (coordinatorData.zone_id) {
          // Zone is known — go straight through
          loadLgas(coordinatorData.zone_id);

        } else if (coordinatorData.lga_id) {
          // Zone unknown — derive it from the LGA
          $.get(`/coordinator/lgas/${coordinatorData.lga_id}`, function (data) {
            const derivedZoneId = data.lga.zone_id ?? null;

            if (derivedZoneId) {
              $('#zone').val(derivedZoneId);
              // Now load LGAs for that zone so the zone dropdown is also populated
              $.get(`/coordinator/zones/${derivedZoneId}`, function (data) {
                populateSelect('#lga', data.zone.lgas, 'Select LGA', coordinatorData.lga_id);
                loadWards(coordinatorData.lga_id);
              });
            } else {
              // Can't determine zone — just load wards directly
              loadWards(coordinatorData.lga_id);
            }
          });
        }
      });
    }

    cvrModal.show();
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-cvr-btn', function () {
    const btn = $(this);
    editingId = btn.data('id');

    $('#cvr-modal-title').text('Edit CVR');
    $('#cvr-submit-btn').text('Update CVR');
    clearErrors();

    $('#unique_id').val(btn.data('unique_id'));
    $('#type').val(btn.data('type'));
    $('#status').val(btn.data('status'));

    const stateId = btn.data('state_id');
    const zoneId  = btn.data('zone_id');
    const lgaId   = btn.data('lga_id');
    const wardId  = btn.data('ward_id');
    const puId    = btn.data('pu_id');

    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');

    if (stateId) {
      $('#state').val(stateId);
      $.get(`/coordinator/states/${stateId}`, function (data) {
        populateSelect('#zone', data.state.zones, 'Select zone', zoneId);
        if (zoneId) {
          $.get(`/coordinator/zones/${zoneId}`, function (data) {
            populateSelect('#lga', data.zone.lgas, 'Select LGA', lgaId);
            if (lgaId) {
              $.get(`/coordinator/lgas/${lgaId}`, function (data) {
                populateSelect('#ward', data.lga.wards, 'Select ward', wardId);
                if (wardId) {
                  $.get(`/coordinator/wards/${wardId}`, function (data) {
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

  // ── CASCADING SELECTS ────────────────────────────────────
  $('#state').on('change', function () {
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/coordinator/states/${id}`, function (data) {
      populateSelect('#zone', data.state.zones, 'Select zone');
    });
  });

  $('#zone').on('change', function () {
    resetSelect('#lga',  'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/coordinator/zones/${id}`, function (data) {
      populateSelect('#lga', data.zone.lgas, 'Select LGA');
    });
  });

  $('#lga').on('change', function () {
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu',   'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/coordinator/lgas/${id}`, function (data) {
      populateSelect('#ward', data.lga.wards, 'Select ward');
    });
  });

  $('#ward').on('change', function () {
    resetSelect('#pu', 'Select PU');
    const id = $(this).val();
    if (!id) return;
    $.get(`/coordinator/wards/${id}`, function (data) {
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