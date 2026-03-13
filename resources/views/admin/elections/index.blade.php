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
      <h1>Elections Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Elections</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">Elections List</h5>
                <button id="create-election-btn" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Create Election
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all elections in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="elections-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>Type</th>
                      <th>Date</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($elections as $election)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-dark">{{ $election->type }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ $election->date }}</span></td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary view-election-btn"
                              title="View"
                              data-id="{{ $election->id }}">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success edit-election-btn"
                              title="Edit"
                              data-id="{{ $election->id }}"
                              data-type="{{ $election->type }}"
                              data-date="{{ $election->date }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-election-btn"
                              title="Delete"
                              data-id="{{ $election->id }}">
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
                  Showing {{ $elections->firstItem() ?? 0 }} to {{ $elections->lastItem() ?? 0 }} of {{ $elections->total() }} entries
                </div>
                <div>{{ $elections->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.elections.modal')

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

  const electionModalEl = document.getElementById('election-modal');
  const electionModal   = new bootstrap.Modal(electionModalEl);
  const viewModalEl     = document.getElementById('election-view-modal');
  const viewModal       = new bootstrap.Modal(viewModalEl);
  let editingId         = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    electionModal.hide();
  });

  // ── RESET ON CLOSE (edit/create modal) ───────────────────
  electionModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#election-form')[0].reset();
    clearErrors();
    const focused = document.activeElement;
    if (focused && electionModalEl.contains(focused)) focused.blur();
    $('#create-election-btn').trigger('focus');
  });

  // ── RESET ON CLOSE (view modal) ──────────────────────────
  viewModalEl.addEventListener('hidden.bs.modal', function () {
    $('#view-election-type, #view-election-date').text('—');
    const focused = document.activeElement;
    if (focused && viewModalEl.contains(focused)) focused.blur();
    $('#create-election-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-election-btn').on('click', function () {
    editingId = null;
    $('#election-modal-title').text('Create Election');
    $('#election-submit-btn').text('Save Election');
    clearErrors();
    electionModal.show();
  });

  // ── OPEN FOR VIEW ────────────────────────────────────────
  $(document).on('click', '.view-election-btn', function () {
    const id = $(this).data('id');

    $('#view-election-type').text('Loading...');
    $('#view-election-date').text('—');
    viewModal.show();

    $.get(`/admin/elections/${id}`, function (data) {
      const election = data.election;
      $('#view-election-type').text(election.type);
      $('#view-election-date').text(election.date);
    }).fail(function () {
      toastr.error('Could not load election details', 'Error');
      viewModal.hide();
    });
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-election-btn', function () {
    const btn = $(this);
    editingId = btn.data('id');

    $('#election-modal-title').text('Edit Election');
    $('#election-submit-btn').text('Update Election');
    clearErrors();

    $('#type').val(btn.data('type'));
    $('#date').val(btn.data('date'));

    electionModal.show();
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#election-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/elections';

    if (editingId) {
      url = `/admin/elections/${editingId}`;
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
  $(document).on('click', '.delete-election-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This election will be permanently deleted.',
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
        url: `/admin/elections/${id}`,
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
      electionModal.hide();
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
    $('#elections-table-container').load(location.href + ' #elections-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection