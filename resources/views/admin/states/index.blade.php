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
      <h1>States Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">States</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">States List</h5>
                <button id="create-state-btn" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Add New State
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all states in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="states-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>Name</th>
                      <th>Zones</th>
                      <th>LGAs</th>
                      <th>Wards</th>
                      <th>PUs</th>
                      <th>Voters</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($states as $state)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-dark">{{ $state->name }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ count($state->zones) }}</span></td>
                        <td><span class="badge bg-success rounded-pill">{{ count($state->lgas) }}</span></td>
                        <td><span class="badge bg-info rounded-pill">{{ count($state->wards) }}</span></td>
                        <td><span class="badge bg-warning rounded-pill">{{ count($state->pus) }}</span></td>
                        <td><span class="badge bg-danger rounded-pill">{{ count($state->users) }}</span></td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary view-state-btn"
                              title="View"
                              data-id="{{ $state->id }}">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success edit-state-btn"
                              title="Edit"
                              data-id="{{ $state->id }}"
                              data-name="{{ $state->name }}"
                              data-description="{{ $state->description ?? '' }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-state-btn"
                              title="Delete"
                              data-id="{{ $state->id }}">
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
                  Showing {{ $states->firstItem() ?? 0 }} to {{ $states->lastItem() ?? 0 }} of {{ $states->total() }} entries
                </div>
                <div>{{ $states->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.states.modal')

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

  const stateModalEl = document.getElementById('state-modal');
  const stateModal   = new bootstrap.Modal(stateModalEl);
  const viewModalEl  = document.getElementById('state-view-modal');
  const viewModal    = new bootstrap.Modal(viewModalEl);
  let editingId      = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    stateModal.hide();
  });

  // ── RESET ON CLOSE (edit/create modal) ───────────────────
  stateModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#state-form')[0].reset();
    clearErrors();
    const focused = document.activeElement;
    if (focused && stateModalEl.contains(focused)) focused.blur();
    $('#create-state-btn').trigger('focus');
  });

  // ── RESET ON CLOSE (view modal) ──────────────────────────
  viewModalEl.addEventListener('hidden.bs.modal', function () {
    $('#view-state-name, #view-state-description').text('—');
    const focused = document.activeElement;
    if (focused && viewModalEl.contains(focused)) focused.blur();
    $('#create-state-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-state-btn').on('click', function () {
    editingId = null;
    $('#state-modal-title').text('Create State');
    $('#state-submit-btn').text('Save State');
    clearErrors();
    stateModal.show();
  });

  // ── OPEN FOR VIEW ────────────────────────────────────────
  $(document).on('click', '.view-state-btn', function () {
    const id = $(this).data('id');

    $('#view-state-name').text('Loading...');
    $('#view-state-description').text('—');
    viewModal.show();

    $.get(`/admin/states/${id}`, function (data) {
      const state = data.state;
      $('#view-state-name').text(state.name);
      $('#view-state-description').text(state.description || '—');
    }).fail(function () {
      toastr.error('Could not load state details', 'Error');
      viewModal.hide();
    });
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-state-btn', function () {
    const btn = $(this);
    editingId = btn.data('id');

    $('#state-modal-title').text('Edit State');
    $('#state-submit-btn').text('Update State');
    clearErrors();

    $('#name').val(btn.data('name'));
    $('#description').val(btn.data('description'));

    stateModal.show();
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#state-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/states';

    if (editingId) {
      url = `/admin/states/${editingId}`;
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
  $(document).on('click', '.delete-state-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This state will be permanently deleted.',
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
        url: `/admin/states/${id}`,
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
      stateModal.hide();
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
    $('#states-table-container').load(location.href + ' #states-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection