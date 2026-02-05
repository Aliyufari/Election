@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.admin.sidebar')
@endsection

@section('content')
<main id="main" class="main">

  <!-- Page Title -->
  <div class="pagetitle mb-4">
    <h1 class="fw-bold">CVR Panel</h1>
    <p class="text-muted mb-0">
      {{ $state->name }} State Continuous Voter Registration Overview
    </p>
  </div>

  <section class="section profile">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-body pt-3">

            <!-- Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered mb-4">
              <li class="nav-item">
                <button
                  class="nav-link active fw-semibold"
                  data-bs-toggle="tab"
                  data-bs-target="#zones-overview">
                  {{ $state->name }} State Zones
                </button>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane fade show active" id="zones-overview">

                <!-- Summary Cards -->
                <div class="row g-4 mb-4">

                  <div class="col-md-4">
                    <div class="card border-primary shadow-lg h-100">
                      <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                          <small class="text-primary fw-semibold">State</small>
                          <h3 class="fw-bold mb-0">{{ $state->name }}</h3>
                        </div>
                        <i class="bi bi-house text-primary fs-1"></i>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="card border-success shadow-lg h-100">
                      <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                          <small class="text-success fw-semibold">Zones</small>
                          <h3 class="fw-bold mb-0">{{ count($zones) }}</h3>
                        </div>
                        <i class="bi bi-geo-alt-fill text-success fs-1"></i>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="card border-info shadow-lg h-100">
                      <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                          <small class="text-info fw-semibold">Total CVRs</small>
                          <h3 class="fw-bold mb-0">{{ $stateCvrCount }}</h3>
                        </div>
                        <i class="bi bi-file-text text-info fs-1"></i>
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Zones List -->
                <div class="list-group list-group-flush">

                  @forelse($zones as $zone)
                    <div class="list-group-item py-3 bg-light border rounded-3 shadow-sm mb-2">
                      <div class="row align-items-center">

                        <div class="col-md-9">
                          <h6 class="fw-bold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-geo-alt me-2 text-primary"></i>
                            {{ $zone->name }}
                          </h6>

                          <div class="d-flex flex-wrap gap-3 small text-muted mt-1">
                            <span class="d-flex align-items-center">
                              <i class="bi bi-shop me-1 text-secondary"></i>
                              <strong class="me-1">{{ count($zone->lgas) }}</strong> LGAs
                            </span>

                            <span class="d-flex align-items-center">
                              <i class="bi bi-file-text me-1 text-secondary"></i>
                              <strong class="me-1">{{ $zone->cvr_count }}</strong> CVRs
                            </span>
                          </div>
                        </div>

                        <div class="col-md-3 text-md-end mt-3 mt-md-0">
                          <a
                            href="/admin/states/{{ $state->id }}/zones/{{ $zone->id }}/cvr"
                            class="btn btn-outline-primary btn-sm px-3">
                            <i class="bi bi-eye me-1"></i>
                            View CVRs
                          </a>
                        </div>

                      </div>
                    </div>
                  @empty
                    <div class="alert alert-warning">
                      No zones found for this state.
                    </div>
                  @endforelse

                </div>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection
