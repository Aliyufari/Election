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
                      <td><span class="badge bg-success rounded-pill">{{ $cvr->pu->ward->name }}</span></td>
                      <td><span class="badge bg-info rounded-pill">{{ $cvr->pu->name }}</span></td>
                      <td><span class="badge bg-warning rounded-pill">{{ $cvr->status }}</span></td>
                      <td class="text-muted small">{{ $cvr->created_at->format('d M Y, h:i A') }}</td>
                      <td class="text-muted small">{{ $cvr->updated_at->format('d M Y, h:i A') }}</td>
                      <td class="text-center pe-3">
                        <div class="btn-group" role="group">
                          <a href="/admin/cvrs/{{ $cvr->id }}" class="btn btn-sm btn-outline-primary" title="View">
                            <i class="bi bi-eye"></i>
                          </a>
                          <a href="/admin/cvrs/{{ $cvr->id }}/edit" class="btn btn-sm btn-outline-success" title="Edit">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <form method="POST" action="/admin/cvrs/{{ $cvr->id }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this CVR?')">
                              <i class="bi bi-trash"></i>
                            </button>
                          </form>
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

@include('admin.cvr.add-cvr-modal')

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

  // CSRF Setup
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  // Bootstrap modal
  const cvrModalEl = document.getElementById('cvr-modal');
  const cvrModal   = new bootstrap.Modal(cvrModalEl);

  // Open modal
  $('#create-cvr-btn').on('click', function () {
    $('#cvr-form')[0].reset();
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga', 'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu', 'Select PU');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('').hide();
    cvrModal.show();
  });

  // Submit CVR form
  $('#cvr-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "/admin/cvrs",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: handleCvrResponse,
      error: function(xhr) {
        if (xhr.status === 422) handleCvrResponse(xhr.responseJSON);
        else toastr.error('Something went wrong', 'Error');
      }
    });
  });

  function handleCvrResponse(response) {
    const errors = response.errors || {};
    const map = {
      unique_id: '#unique_id-error',
      type: '#type-error',
      state_id: '#state-error',
      zone_id: '#zone-error',
      lga_id: '#lga-error',
      ward_id: '#ward-error',
      pu_id: '#pu-error',
      status: '#status-error'
    };

    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('').hide();

    $.each(map, function(key, el) {
      if (errors[key]) {
        $('#' + key).addClass('is-invalid');
        $(el).text(errors[key][0]).show();
      }
    });

    if (response.status) {
      cvrModal.hide();
      toastr.success(response.message, 'Success');
      // Refresh only table
      $("#cvr-table-container").load(location.href + " #cvr-table-container > *");
    }
  }

  // Cascading selects
  $('#state').on('change', function() {
    const stateId = $(this).val();
    resetSelect('#zone', 'Select zone');
    resetSelect('#lga', 'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu', 'Select PU');

    if (!stateId) return;

    $.get(`/admin/states/${stateId}`, function(data) {
      let options = '<option value="">Select zone</option>';
      data.state.zones.forEach(zone => {
        options += `<option value="${zone.id}">${zone.name}</option>`;
      });
      $('#zone').html(options).prop('disabled', false);
    });
  });

  $('#zone').on('change', function() {
    const zoneId = $(this).val();
    resetSelect('#lga', 'Select LGA');
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu', 'Select PU');
    if (!zoneId) return;

    $.get(`/admin/zones/${zoneId}`, function(data) {
      let options = '<option value="">Select LGA</option>';
      data.zone.lgas.forEach(lga => {
        options += `<option value="${lga.id}">${lga.name}</option>`;
      });
      $('#lga').html(options).prop('disabled', false);
    });
  });

  $('#lga').on('change', function() {
    const lgaId = $(this).val();
    resetSelect('#ward', 'Select ward');
    resetSelect('#pu', 'Select PU');
    if (!lgaId) return;

    $.get(`/admin/lgas/${lgaId}`, function(data) {
      let options = '<option value="">Select ward</option>';
      data.lga.wards.forEach(ward => {
        options += `<option value="${ward.id}">${ward.name}</option>`;
      });
      $('#ward').html(options).prop('disabled', false);
    });
  });

  $('#ward').on('change', function() {
    const wardId = $(this).val();
    resetSelect('#pu', 'Select PU');
    if (!wardId) return;

    $.get(`/admin/wards/${wardId}`, function(data) {
      let options = '<option value="">Select PU</option>';
      data.ward.pus.forEach(pu => {
        options += `<option value="${pu.id}">${pu.name}</option>`;
      });
      $('#pu').html(options).prop('disabled', false);
    });
  });

  function resetSelect(selector, label) {
    $(selector)
      .html(`<option value="">${label}</option>`)
      .prop('disabled', true);
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
