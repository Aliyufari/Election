@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.coordinators.sidebar')
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
                  {{ $ward->name }} CVR Statistical Analysis
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
                            <small class="text-primary fw-semibold">Ward</small>
                            <h3 class="fw-bold mb-0">{{ $ward->name }}</h3>
                            </div>
                            <i class="bi bi-collection text-primary fs-1"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-success fw-semibold">PUs</small>
                            <h3 class="fw-bold mb-0">{{ count($pus) }}</h3>
                            </div>
                            <i class="bi bi-pin-map text-success fs-1"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-info shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-info fw-semibold">Total CVRs</small>
                            <h3 class="fw-bold mb-0">{{ $wardCvrCount }}</h3>
                            </div>
                            <i class="bi bi-file-text text-info fs-1"></i>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- PU List -->
                <div class="list-group list-group-flush">

                  @forelse($pus as $pu)
                    <div class="list-group-item py-3 bg-light border rounded-3 shadow-sm mb-2">
                        <div class="row align-items-center">

                        <div class="col-md-9">
                            <h6 class="fw-bold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-flag me-2 text-primary"></i>
                            {{ $pu->name }}
                            </h6>

                            <div class="d-flex flex-wrap gap-3 small text-muted mt-1">
                                <span class="d-flex align-items-center">
                                    <strong class="me-1">{{ $pu->number }}</strong>
                                </span>

                                <span class="d-flex align-items-center">
                                    <i class="bi bi-file-text me-1 text-secondary"></i>
                                    <strong class="me-1">{{ $pu->cvr_count }}</strong> CVRs
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mb-3">
                          <button 
                              class="btn btn-outline-success btn-sm px-3" 
                              data-bs-toggle="modal" 
                              data-bs-target="#update-pu-cvr-modal" 
                              data-pu-id="{{ $pu->id }}">
                              Add CVRs
                          </button>

                          <a href="/coordinators/states/{{$pu->state->id}}/zones/{{$pu->zone->id}}/lgas/{{$pu->lga->id}}/wards/{{$pu->ward->id}}/pus/{{$pu->id}}/cvr" 
                            class="btn btn-outline-primary btn-sm px-3">
                              <i class="bi bi-eye me-1"></i>
                              View CVRs
                          </a>
                        </div>

                        </div>
                    </div>
                  @empty
                    <div class="alert alert-warning">
                      No PUs found for this ward.
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

<</main>

@include('coordinators.cvr.update-pu-cvr-modal') {{-- modal partial --}}

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateModal = document.getElementById('update-pu-cvr-modal');

    updateModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const puId = button.getAttribute('data-pu-id');
        const input = updateModal.querySelector('#modal-pu-id');
        input.value = puId;
    });

    const form = document.getElementById('update-pu-cvr-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const puId = form.querySelector('#modal-pu-id').value;
        const count = form.querySelector('#pu-cvr-count').value;

        fetch('/coordinators/cvrs/update-pu', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pu_id: puId, count: count })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Error adding CVRs');
            }
        });
    });
});
</script>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection