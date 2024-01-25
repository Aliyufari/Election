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
      <h1>Total Registered Voters - PU 200</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-3">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-left">

              <h4>Result</h4>
              <h6>Total Accreditation</h6>
              <h3>
                <strong>

                  @php

                    $sum = 0;
                    foreach($zone->pus as $pu)
                    {
                      $sum = $sum + $pu->registration;
                    }

                  @endphp

                  {{ $sum }}

                </strong>
              </h3>
              <hr>
              <div class="">
                <a href="" class="btn btn-info">Refresh</a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-9">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"><h6 class="m-0"><strong>{{$election}}</strong></h6></button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h3 class="card-title">{{count($zone->lgas)}} LGAs</h3>
                  <h3 class="card-title">
                    @php

                      $sum = 0;
                      foreach($zone->pus as $pu)
                      {
                        $sum = $sum + $pu->registration;
                      }

                    @endphp

                    {{ $sum }} Accreditation(s)
                  </h3>
                    @foreach($zone->lgas as $lga)
                     <div class="row" style="background: #ccc; padding: 5px; border-radius: 3px;">
                        <div class="col-lg-9 col-md-9 ">
                          <h6 class="m-0" style="text-transform: uppercase; color: blue;"><i class="bi bi-flag" style="color: black;"></i> {{$lga->name}}</h6>
                          <p class="m-2" style="font-size: 12px;">{{count($lga->wards)}} Wards / RA</p>
                          <h6 class="m-2">{{count($lga->pus)}} Polling Units</h6>
                        </div>
                        <div class="col-lg-3 col-md-3 label">
                           <a href="/lgas/{{$lga->id}}/info/?name={{$election}}" class="btn btn-light">View Wards Accreditation</a>
                        </div>
                      </div>
                    @endforeach
                </div>

                

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
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