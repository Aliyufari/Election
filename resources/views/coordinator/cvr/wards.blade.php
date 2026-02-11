@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.coordinator.sidebar')
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
                  {{ $lga->name }} CVR Statistical Analysis
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
                            <small class="text-primary fw-semibold">LGA</small>
                            <h3 class="fw-bold mb-0">{{ $lga->name }}</h3>
                            </div>
                            <i class="bi bi-shop text-primary fs-1"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-success fw-semibold">Wards</small>
                            <h3 class="fw-bold mb-0">{{ count($wards) }}</h3>
                            </div>
                            <i class="bi bi-collection text-success fs-1"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-info shadow-lg h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                            <small class="text-info fw-semibold">Total CVRs</small>
                            <h3 class="fw-bold mb-0">{{ $lgaCvrCount }}</h3>
                            </div>
                            <i class="bi bi-file-text text-info fs-1"></i>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Ward List -->
                <div class="list-group list-group-flush">

                  @forelse($wards as $ward)
                    <div class="list-group-item py-3 bg-light border rounded-3 shadow-sm mb-2">
                        <div class="row align-items-center">

                        <div class="col-md-9">
                            <h6 class="fw-bold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-flag me-2 text-primary"></i>
                            {{ $ward->name }}
                            </h6>

                            <div class="d-flex flex-wrap gap-3 small text-muted mt-1">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-pin-map me-1 text-secondary"></i>
                                <strong class="me-1">{{ count($ward->pus) }}</strong> PUs
                            </span>

                            <span class="d-flex align-items-center">
                                <i class="bi bi-file-text me-1 text-secondary"></i>
                                <strong class="me-1">{{ $ward->cvr_count }}</strong> CVRs
                            </span>
                            </div>
                        </div>

                        <div class="col-md-3 text-md-end mt-3 mt-md-0 d-flex justify-content-end gap-2">
                          <!-- Update button triggers modal -->
                          <button 
                              class="btn btn-outline-success btn-sm px-2" 
                              data-bs-toggle="modal" 
                              data-bs-target="#update-cvr-modal" 
                              data-ward-id="{{ $ward->id }}">
                              Update
                          </button>

                          <a href="/coordinator/states/{{$lga->state->id}}/zones/{{$lga->zone->id}}/lgas/{{$lga->id}}/wards/{{$ward->id}}/cvr" 
                            class="btn btn-outline-primary btn-sm px-2">
                              <i class="bi bi-eye me-1"></i>
                              View CVRs
                          </a>
                        </div>
                      </div>
                  </div>
                  @empty
                    <div class="alert alert-warning">
                      No wards found for this LGA.
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

@include('coordinator.cvr.update-ward-cvr-modal')

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateModal = document.getElementById('update-cvr-modal');

    updateModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const wardId = button.getAttribute('data-ward-id');
        const input = updateModal.querySelector('#modal-ward-id');
        input.value = wardId;
    });

    // Optional: handle form submission via AJAX
    const form = document.getElementById('update-cvr-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const wardId = form.querySelector('#modal-ward-id').value;
        const count = form.querySelector('#cvr-count').value;

        // Example: AJAX request
        fetch('/coordinator/cvrs/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ward_id: wardId, count: count })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload(); // or update the count dynamically
            } else {
                // Handle errors
                alert('Error updating CVRs');
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
