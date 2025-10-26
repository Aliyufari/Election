@extends('layouts.app')

@section('header')
  @include('pertials.header')
@endsection

@section('sidebar')
  @include('pertials.sidebar')
@endsection

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Messages</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item">CVR Panel</li>
          <li class="breadcrumb-item active">Total registered Voters</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <!-- Messages-->
            <div class="col-12">
              <div class="card top-messages overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Total Registered Voters</h5>
                  <hr>

                  <div class="fw-bold text-primary mb-3">
                    <i class="bi bi-search"></i>
                    <a>2019 Total Registered Voters: 21 143 501</a>
                  </div>

                  <div class="fw-bold text-primary mb-3">
                    <i class="bi bi-search"></i>
                    <a>2023 Total Registered Voters: 25 236 967</a>
                  </div>

                  <div class="fw-bold text-primary mb-3">
                    <i class="bi bi-search"></i>
                    <a>Difference Between 2019 and 2023: 1 587 018</a>
                  </div>

                  <h5 class="card-title mb-0 text-dark fw-bold">2026 CVR Update</h5>
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        {{-- <th scope="col">S/N</th> --}}
                        <th scope="col">PUs</th>
                        <th scope="col">Ward</th>
                        <th scope="col">LGAs</th>
                        <th scope="col">Zones</th>
                        <th scope="col">States</th>
                        {{-- <th scope="col">Actions</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        {{-- <td class="ps-3 fw-medium">{{ $sn }}</td> --}}
                        <td class="badge bg-danger rounded-pill">{{ 7456 }}</td>
                        <td>
                          <span class="badge bg-primary rounded-pill">{{ 541 }}</span>
                        </td>
                        <td>
                          <span class="badge bg-success rounded-pill">{{ 321 }}</span>
                        </td>
                        <td>
                          <span class="badge bg-info rounded-pill">{{ 288 }}</span>
                        </td>
                        <td>
                          <span class="badge bg-warning rounded-pill">{{ 19 }}</span>
                        </td>
                        {{-- <td class="text-center pe-3">
                          
                        </td> --}}
                      </tr>
                    </tbody>
                  </table>
                  <hr>
                </div>

              </div>
            </div><!-- End Top Messages -->
      </div>
    </section>

  </main><!-- End #main -->
@endsection

@section('footer')
  @include('pertials.footer')
@endsection

@section('toast')
  @include('pertials.toast')
@endsection