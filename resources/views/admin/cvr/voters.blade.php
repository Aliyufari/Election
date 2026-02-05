@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.admin.sidebar')
@endsection

@php
$firstPhaseTotalVoters = 0;
$secondPhaseTotalVoters = 0;

foreach ($states as $state) {
    foreach ($state->wards as $ward) {
        foreach ($ward->voters as $voter) {
            $firstPhaseTotalVoters += $voter->first_phase_figure ?? 0;
            $secondPhaseTotalVoters += $voter->second_phase_figure ?? 0;
        }
    }
}
@endphp

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold">CVR Panel</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">CVR Panel</li>
                <li class="breadcrumb-item active">Total Registered Voters</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">

                        {{-- Header Section --}}
                        <h5 class="card-title fw-bold mb-3">Total Registered Voters</h5>
                        <hr>

                        {{-- Voter Count Cards --}}
                        <div class="row g-4 mb-4">
                            <!-- 2019 Card -->
                            <div class="col-md-4">
                                <div class="card shadow-lg rounded-4 border-0 text-center p-4">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-person-badge text-primary fs-1 me-3"></i>
                                        <h4 class="fw-bold mb-0 text-dark">21,143,501</h4>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        Total Registered Voters During 2023 General Election
                                    </p>
                                </div>
                            </div>

                            <!-- 2025/2026 Card -->
                            <div class="col-md-4">
                                <div class="card shadow-lg rounded-4 border-0 text-center p-4 position-relative">
                                    <!-- Small pen icon button -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-success position-absolute top-0 end-0 m-2"
                                        title="Update"
                                        data-bs-toggle="modal"
                                        data-bs-target="#update-cvr-figure-modal"
                                        data-type="first_phase"
                                        data-label="2025/2026 First Phase of CVR Total (4 Months)"
                                        data-value="967">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-person-badge text-info fs-1 me-3"></i>
                                        <h4 class="fw-bold mb-0 text-dark" id="card-first-phase">{{ $firstPhaseTotalVoters }}</h4>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        2025/2026 First Phase of CVR Total (4 Months)
                                    </p>
                                </div>
                            </div>

                            <!-- Difference Card -->
                            <div class="col-md-4">
                                <div class="card shadow-lg rounded-4 border-0 text-center p-4 position-relative">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-success position-absolute top-0 end-0 m-2"
                                        title="Update"
                                        data-bs-toggle="modal"
                                        data-bs-target="#update-cvr-figure-modal"
                                        data-type="second_phase"
                                        data-label="2025/2026 Second Phase Projects (4 Months)"
                                        data-value="110">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-graph-up-arrow text-success fs-1 me-3"></i>
                                        <h4 class="fw-bold mb-0 text-dark" id="card-second-phase">{{ $secondPhaseTotalVoters  }}</h4>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        2025/2026 Second Phase Projects (4 Months)
                                    </p>
                                </div>
                            </div>

                        </div>

                        {{-- Filter Section --}}
                        <h5 class="fw-bold text-dark mb-3">2026 CVR Update</h5>
                        <div class="row g-3 mb-4 align-items-end justify-content-between">

                            <div class="col-md-9">
                                <div class="row g-3">

                                    <div class="col-md-3">
                                        <label class="form-label">State</label>
                                        <select class="form-select" id="filter-state">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Zone</label>
                                        <select class="form-select" id="filter-zone" disabled>
                                            <option value="">Select Zone</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">LGA</label>
                                        <select class="form-select" id="filter-lga" disabled>
                                            <option value="">Select LGA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Ward</label>
                                        <select class="form-select" id="filter-ward" disabled>
                                            <option value="">Select Ward</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="table-responsive mb-3">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>State</th>
                                        <th>Zones</th>
                                        <th>LGAs</th>
                                        <th>Wards</th>
                                        <th>PUs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($states as $state)
                                    <tr>
                                        <td><span class="badge bg-warning text-dark rounded-pill">{{ $state->name }}</span></td>
                                        <td><span class="badge bg-info text-dark rounded-pill">{{ count($state->zones) }}</span></td>
                                        <td><span class="badge bg-success rounded-pill">{{ count($state->lgas) }}</span></td>
                                        <td><span class="badge bg-primary rounded-pill">{{ count($state->wards) }}</span></td>
                                        <td><span class="badge bg-danger rounded-pill">{{ count($state->pus) }}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                    </div> <!-- End card-body -->
                </div> <!-- End card -->
            </div>
        </div>

    </section>
</main>

@include('admin.cvr.update-cvr-figure-modal')

@endsection

@section('script')
<script>
$(document).ready(function () {

    /* =====================================================
     *  FILTER SELECTS (STATE → ZONE → LGA → WARD)
     * ===================================================== */
    const $state = $('#filter-state');
    const $zone  = $('#filter-zone');
    const $lga   = $('#filter-lga');
    const $ward  = $('#filter-ward');

    function resetSelect($select, label) {
        $select.html(`<option value="">${label}</option>`).prop('disabled', true);
    }

    // --- State → Zones ---
    $state.on('change', function () {
        const stateId = $(this).val();

        resetSelect($zone, 'Select Zone');
        resetSelect($lga, 'Select LGA');
        resetSelect($ward, 'Select Ward');

        if (!stateId) return;

        $.get(`/admin/states/${stateId}`, function (data) {
            let options = '<option value="">Select Zone</option>';
            data.state.zones.forEach(zone => {
                options += `<option value="${zone.id}">${zone.name}</option>`;
            });
            $zone.html(options).prop('disabled', false);
        });
    });

    // --- Zone → LGAs ---
    $zone.on('change', function () {
        const zoneId = $(this).val();

        resetSelect($lga, 'Select LGA');
        resetSelect($ward, 'Select Ward');

        if (!zoneId) return;

        $.get(`/admin/zones/${zoneId}`, function (data) {
            let options = '<option value="">Select LGA</option>';
            data.zone.lgas.forEach(lga => {
                options += `<option value="${lga.id}">${lga.name}</option>`;
            });
            $lga.html(options).prop('disabled', false);
        });
    });

    // --- LGA → Wards ---
    $lga.on('change', function () {
        const lgaId = $(this).val();

        resetSelect($ward, 'Select Ward');

        if (!lgaId) return;

        $.get(`/admin/lgas/${lgaId}`, function (data) {
            let options = '<option value="">Select Ward</option>';
            data.lga.wards.forEach(ward => {
                options += `<option value="${ward.id}">${ward.name}</option>`;
            });
            $ward.html(options).prop('disabled', false);
        });
    });


    /* =====================================================
     *  MODAL SELECTS (STATE → ZONE → LGA → WARD)
     * ===================================================== */
    const $mState = $('#modal-state');
    const $mZone  = $('#modal-zone');
    const $mLga   = $('#modal-lga');
    const $mWard  = $('#modal-ward');

    function resetModalSelect($select, label) {
        $select.html(`<option value="">${label}</option>`).prop('disabled', true);
    }

    // --- Modal: State → Zones ---
    $mState.on('change', function () {
        const stateId = $(this).val();

        resetModalSelect($mZone, 'Select Zone');
        resetModalSelect($mLga, 'Select LGA');
        resetModalSelect($mWard, 'Select Ward');

        if (!stateId) return;

        $.get(`/admin/states/${stateId}`, function (data) {
            let options = '<option value="">Select Zone</option>';
            data.state.zones.forEach(zone => {
                options += `<option value="${zone.id}">${zone.name}</option>`;
            });
            $mZone.html(options).prop('disabled', false);
        });
    });

    // --- Modal: Zone → LGAs ---
    $mZone.on('change', function () {
        const zoneId = $(this).val();

        resetModalSelect($mLga, 'Select LGA');
        resetModalSelect($mWard, 'Select Ward');

        if (!zoneId) return;

        $.get(`/admin/zones/${zoneId}`, function (data) {
            let options = '<option value="">Select LGA</option>';
            data.zone.lgas.forEach(lga => {
                options += `<option value="${lga.id}">${lga.name}</option>`;
            });
            $mLga.html(options).prop('disabled', false);
        });
    });

    // --- Modal: LGA → Wards ---
    $mLga.on('change', function () {
        const lgaId = $(this).val();

        resetModalSelect($mWard, 'Select Ward');

        if (!lgaId) return;

        $.get(`/admin/lgas/${lgaId}`, function (data) {
            let options = '<option value="">Select Ward</option>';
            data.lga.wards.forEach(ward => {
                options += `<option value="${ward.id}">${ward.name}</option>`;
            });
            $mWard.html(options).prop('disabled', false);
        });
    });


    /* =====================================================
     *  UPDATE CVR FIGURE MODAL
     * ===================================================== */
    $('#update-cvr-figure-modal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);

        $('#modal-cvr-type').val(button.data('type'));
        $('#modal-cvr-value').val(button.data('value'));
        $('#modal-cvr-label').text(button.data('label'));

        // Reset modal selects on open
        resetModalSelect($mZone, 'Select Zone');
        resetModalSelect($mLga, 'Select LGA');
        resetModalSelect($mWard, 'Select Ward');
    });

    $('#update-cvr-figure-form').on('submit', function (e) {
        e.preventDefault();

        if (!$('#modal-ward').val()) {
            alert('Please select a ward');
            return;
        }

        $.ajax({
            url: '/admin/cvr/update-figure',
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message || 'Failed to update');
                }
            },
            error: function (xhr) {
                alert(
                    xhr.responseJSON?.message ??
                    'Validation failed. Please check inputs.'
                );
            }
        });
    });

    $('#filter-state, #filter-zone, #filter-lga, #filter-ward').on('change', function() {
        applyFilter();
    });

    function applyFilter() {
        const stateId = $('#filter-state').val();
        const zoneId  = $('#filter-zone').val();
        const lgaId   = $('#filter-lga').val();
        const wardId  = $('#filter-ward').val();

        $.ajax({
            url: '/admin/cvr/voters',
            method: 'GET',
            data: {
                state_id: stateId,
                zone_id: zoneId,
                lga_id: lgaId,
                ward_id: wardId
            },
            success: function(res) {
                // Update Cards
                $('#card-first-phase').text(res.first_phase_total);
                $('#card-second-phase').text(res.second_phase_total);

                // Update Table
                const tbody = $('table tbody');
                tbody.empty();

                res.states.forEach(state => {
                    tbody.append(`
                        <tr>
                            <td><span class="badge bg-warning text-dark rounded-pill">${state.name}</span></td>
                            <td><span class="badge bg-info text-dark rounded-pill">${state.zones.length}</span></td>
                            <td><span class="badge bg-success rounded-pill">${state.lgas.length}</span></td>
                            <td><span class="badge bg-primary rounded-pill">${state.wards.length}</span></td>
                            <td><span class="badge bg-danger rounded-pill">${state.pus.length}</span></td>
                        </tr>
                    `);
                });
            }
        });
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