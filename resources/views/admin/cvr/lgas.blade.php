@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.sidebar')
@endsection

@section('content')
<main id="main" class="main">

  <!-- Page Title -->
  <div class="pagetitle mb-4">
    <h1 class="fw-bold">CVR Panel</h1>
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
                  data-bs-target="#profile-overview">
                  {{ $zone->name }} CVR Statistical Analysis
                </button>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane fade show active" id="profile-overview">

                <!-- Summary Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-primary fw-semibold">Zone</small>
                            <h3 class="fw-bold mb-0">{{ $zone->name }}</h3>
                            </div>
                            <i class="bi bi-geo-alt-fill text-primary fs-1"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-success fw-semibold">LGAs</small>
                            <h3 class="fw-bold mb-0">{{ count($lgas) }}</h3>
                            </div>
                            <i class="bi bi-shop text-success fs-1"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-info shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-info fw-semibold">Total CVRs</small>
                            <h3 class="fw-bold mb-0">{{ $zoneCvrCount }}</h3>
                            </div>
                            <i class="bi bi-file-text text-info fs-1"></i>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- LGA List -->
                <div class="list-group list-group-flush">

                  @forelse($lgas as $lga)
                    <div class="list-group-item py-3 bg-light border rounded-3 shadow-sm mb-2">
                        <div class="row align-items-center">

                        <div class="col-md-9">
                            <h6 class="fw-bold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-flag me-2 text-primary"></i>
                            {{ $lga->name }}
                            </h6>

                            <div class="d-flex flex-wrap gap-3 small text-muted mt-1">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-collection me-1 text-secondary"></i>
                                <strong class="me-1">{{ count($lga->wards) }}</strong> Wards
                            </span>

                            <span class="d-flex align-items-center">
                                <i class="bi bi-file-text me-1 text-secondary"></i>
                                <strong class="me-1">{{ $lga->cvr_count }}</strong> CVRs
                            </span>
                            </div>
                        </div>

                        <div class="col-md-3 text-md-end mt-3 mt-md-0">
                            <a href="/admin/states/{{$zone->state->id}}/zones/{{$zone->id}}/lgas/{{$lga->id}}/cvr" class="btn btn-outline-primary btn-sm px-3">
                            <i class="bi bi-eye me-1"></i>
                            View CVRs
                            </a>
                        </div>

                        </div>
                    </div>
                  @empty
                    <div class="alert alert-warning">
                      No LGAs found for this zone.
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
