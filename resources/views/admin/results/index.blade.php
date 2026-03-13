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
      <h1>Results</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Results</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark fw-bold">Recent Uploaded Results</h5>
                <button id="create-result-btn" class="btn btn-primary">
                  <i class="bi bi-upload me-1"></i>Upload Result
                </button>
              </div>
              <p class="text-muted mt-2 mb-0">Manage all uploaded results in the system</p>
            </div>

            <div class="card-body pt-3">
              <div class="table-responsive" id="results-table-container">
                <table class="table table-hover table-borderless">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-3">S/N</th>
                      <th>PU</th>
                      <th>Election</th>
                      <th>Image</th>
                      <th class="text-center pe-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($results as $result)
                      <tr class="border-bottom">
                        <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                        <td class="fw-semibold text-dark">{{ $result->pu->name }}</td>
                        <td>{{ $result->election->type }}</td>
                        <td>
                          <img src="{{ $result->image ? asset('storage/' . $result->image) : asset('assets/img/results/result.jpg') }}"
                            style="max-width:40px; max-height:40px; object-fit:cover; border-radius:4px;"
                            alt="{{ $result->pu->name }} Result">
                        </td>
                        <td class="text-center pe-3">
                          <div class="btn-group" role="group">
                            <a href="/admin/results/{{ $result->id }}" class="btn btn-sm btn-outline-primary" title="View">
                              <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-success edit-result-btn"
                              title="Edit"
                              data-id="{{ $result->id }}"
                              data-pu_id="{{ $result->pu_id }}"
                              data-election_id="{{ $result->election_id }}"
                              data-image="{{ $result->image ? asset('storage/' . $result->image) : '' }}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-result-btn"
                              title="Delete"
                              data-id="{{ $result->id }}">
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
                  Showing {{ $results->firstItem() ?? 0 }} to {{ $results->lastItem() ?? 0 }} of {{ $results->total() }} entries
                </div>
                <div>{{ $results->links() }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  @include('admin.results.modal')

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

  const resultModalEl = document.getElementById('result-modal');
  const resultModal   = new bootstrap.Modal(resultModalEl);
  let editingId       = null;

  // ── CANCEL BUTTON ────────────────────────────────────────
  $('#modal-cancel-btn').on('click', function () {
    $(this).blur();
    resultModal.hide();
  });

  // ── RESET ON CLOSE ───────────────────────────────────────
  resultModalEl.addEventListener('hidden.bs.modal', function () {
    editingId = null;
    $('#result-form')[0].reset();
    $('#image-hint').text('');
    $('#image-preview-wrapper').addClass('d-none');
    $('#image-preview').attr('src', '');
    clearErrors();
    const focused = document.activeElement;
    if (focused && resultModalEl.contains(focused)) focused.blur();
    $('#create-result-btn').trigger('focus');
  });

  // ── OPEN FOR CREATE ──────────────────────────────────────
  $('#create-result-btn').on('click', function () {
    editingId = null;
    $('#result-modal-title').text('Upload Result');
    $('#result-submit-btn').text('Upload Result');
    $('#image-hint').text('');
    clearErrors();
    resultModal.show();
  });

  // ── OPEN FOR EDIT ────────────────────────────────────────
  $(document).on('click', '.edit-result-btn', function () {
    const btn     = $(this);
    editingId     = btn.data('id');
    const imgSrc  = btn.data('image');

    $('#result-modal-title').text('Edit Result');
    $('#result-submit-btn').text('Update Result');
    $('#image-hint').text('(leave blank to keep current)');
    clearErrors();

    $('#pu_id').val(btn.data('pu_id'));
    $('#election_id').val(btn.data('election_id'));

    if (imgSrc) {
      $('#image-preview').attr('src', imgSrc);
      $('#image-preview-wrapper').removeClass('d-none');
    } else {
      $('#image-preview-wrapper').addClass('d-none');
    }

    resultModal.show();
  });

  // ── SUBMIT (create or update) ────────────────────────────
  $('#result-form').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let url = '/admin/results';

    if (editingId) {
      url = `/admin/results/${editingId}`;
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
  $(document).on('click', '.delete-result-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This result will be permanently deleted.',
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
        url: `/admin/results/${id}`,
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
      resultModal.hide();
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
    $('#results-table-container').load(location.href + ' #results-table-container > *');
  }

});
</script>
@endsection

@section('toast')
  @include('partials.toast')
@endsection