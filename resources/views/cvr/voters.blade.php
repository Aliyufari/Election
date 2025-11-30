@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.sidebar')
@endsection

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
                        <div class="row g-3 mb-4 align-items-start justify-content-between">
                            <div class="col-md-9">
                                <div class="row g-3">

                                    <!-- 2019 Card -->
                                    <div class="col-md-4">
                                        <div class="p-3 rounded shadow bg-white d-flex align-items-center">
                                            <i class="bi bi-person-badge text-primary fs-1 me-3"></i>
                                            <div>
                                                <div class="fw-bold fs-5 text-dark">21,143,501</div>
                                                <small class="text-muted">Registered Voters</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2023 Card -->
                                    <div class="col-md-4">
                                        <div class="p-3 rounded shadow bg-white d-flex align-items-center">
                                            <i class="bi bi-person-badge text-primary fs-1 me-3"></i>
                                            <div>
                                                <div class="fw-bold fs-5 text-dark">967</div>
                                                <small class="text-muted">Registered Today</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Difference Card -->
                                    <div class="col-md-4">
                                        <div class="p-3 rounded shadow bg-white d-flex align-items-center">
                                            <i class="bi bi-graph-up-arrow text-success fs-1 me-3"></i>
                                            <div>
                                                <div class="fw-bold fs-5 text-dark">110</div>
                                                <small class="text-muted">Inter-State Transfer</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Update Button -->
                            <div class="col-md-auto d-flex align-items-start">
                                <button type="button" class="btn btn-success">
                                    <i class="bi bi-arrow-repeat me-1"></i> Update
                                </button>
                            </div>
                        </div>

                        {{-- Filter Section --}}
                        <h5 class="fw-bold text-dark mb-3">2026 CVR Update</h5>
                        <div class="row g-3 mb-4 align-items-end justify-content-between">

                            <div class="col-md-9">
                                <div class="row g-3">

                                    <div class="col-md-3">
                                        <label class="form-label">State</label>
                                        <select class="form-select">
                                            <option selected>Select State</option>
                                            <option>Bauchi</option>
                                            <option>Gombe</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Zone</label>
                                        <select class="form-select">
                                            <option selected>Select Zone</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">LGA</label>
                                        <select class="form-select">
                                            <option selected>Select LGA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Ward</label>
                                        <select class="form-select">
                                            <option selected>Select Ward</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <!-- Add CVR Button -->
                            <div class="col-md-auto">
                                <button class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Add New CVR
                                </button>
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
                                    <tr>
                                        <td><span class="badge bg-warning text-dark rounded-pill">Cross River</span></td>
                                        <td><span class="badge bg-info text-dark rounded-pill">3</span></td>
                                        <td><span class="badge bg-success rounded-pill">18</span></td>
                                        <td><span class="badge bg-primary rounded-pill">193</span></td>
                                        <td><span class="badge bg-danger rounded-pill">3281</span></td>
                                    </tr>
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
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection