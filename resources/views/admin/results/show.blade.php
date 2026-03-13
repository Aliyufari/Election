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
      <h1>Result Details</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/admin/results">Results</a></li>
          <li class="breadcrumb-item active">View Result</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row justify-content-center">

        <div class="col-xl-8">
          <div class="card border-0 shadow-sm">

            <div class="card-header bg-transparent border-0 pt-3 pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h5 class="fw-bold mb-1">{{ $result->election->type }}</h5>
                  <p class="text-muted small mb-0">
                    PU: <span class="fw-semibold text-dark">{{ $result->pu->number }}{{ $result->pu->name ? ' — ' . $result->pu->name : '' }}</span>
                  </p>
                </div>
                <a href="/admin/results" class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-arrow-left me-1"></i>Back
                </a>
              </div>
            </div>

            <div class="card-body pt-3">

              <!-- Meta -->
              <dl class="row mb-4">
                <dt class="col-sm-3 text-muted fw-normal">State</dt>
                <dd class="col-sm-9">{{ $result->pu->state?->name ?? '—' }}</dd>

                <dt class="col-sm-3 text-muted fw-normal">Zone</dt>
                <dd class="col-sm-9">{{ $result->pu->zone?->name ?? '—' }}</dd>

                <dt class="col-sm-3 text-muted fw-normal">LGA</dt>
                <dd class="col-sm-9">{{ $result->pu->lga?->name ?? '—' }}</dd>

                <dt class="col-sm-3 text-muted fw-normal">Ward</dt>
                <dd class="col-sm-9">{{ $result->pu->ward?->name ?? '—' }}</dd>

                <dt class="col-sm-3 text-muted fw-normal">Election Date</dt>
                <dd class="col-sm-9">{{ $result->election->date }}</dd>
              </dl>

              <hr>

              <!-- Result Image -->
              <h6 class="fw-bold mb-3">Result Sheet</h6>

              @if($result->image)
                <div class="text-center">
                  <img src="{{ asset('storage/' . $result->image) }}"
                    alt="{{ $result->pu->number }} Result"
                    class="img-fluid rounded shadow-sm"
                    style="max-height: 600px; object-fit: contain; cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#image-zoom-modal">
                  <p class="text-muted small mt-2">Click image to enlarge</p>
                </div>
              @else
                <div class="text-center py-5 text-muted">
                  <i class="bi bi-image fs-1 d-block mb-2"></i>
                  No result image uploaded yet.
                </div>
              @endif

            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- Image Zoom Modal -->
  @if($result->image)
  <div class="modal fade" id="image-zoom-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content border-0 bg-transparent shadow-none">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center p-0">
          <img src="{{ asset('storage/' . $result->image) }}"
            alt="{{ $result->pu->number }} Result"
            class="img-fluid rounded">
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- Load result with relationships for the show --}}
  @php $result->load(['pu.state', 'pu.zone', 'pu.lga', 'pu.ward']); @endphp

  <style>
    .modal-backdrop.show { background-color: rgba(0,0,0,0.85); }
  </style>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection