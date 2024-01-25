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
                    foreach($ward->pus as $pu)
                    {
                      $sum = $sum + $pu->accreditation;
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
                  <h3 class="card-title m-0" style="text-transform: uppercase;">LGA: {{$ward->lga->name}}</h3>
                  <h3 class="card-title m-0" style="text-transform: uppercase;">Ward: {{$ward->name}}</h3>
                  <h3 class="card-title m-0">{{count($ward->pus)}} PUs</h3>
                  <h3 class="card-title m-0">
                     @php

                      $sum = 0;
                      foreach($ward->pus as $pu)
                      {
                        $sum = $sum + $pu->accreditation;
                      }

                    @endphp

                  {{ $sum }} Accreditations
                  </h3>
                    @foreach($ward->pus as $pu)
                       <div class="row" style="background: #ccc; padding: 5px; border-radius: 3px;">
                        <div class="col-lg-9 col-md-9 ">
                          <h6 class="m-0" style="text-transform: uppercase; color: blue;"><i class="bi bi-magic" style="color: black;"></i> {{$pu->name}}</h6>
                          <p class="m-0"></p>
                          <h6 class="m-2">PU Code: {{$pu->number}}</h6>
                          <h6 class="m-2">
                            Total Registration: {{$pu->registration}}

                            @if(isset(auth()->user()->name))
                              @if(strtolower(auth()->user()->role) === 'admin')
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrationModal" data-bs-whatever="@getbootstrap">Update</button>

                                <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Registration</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="/pus/{{$pu->id}}/registrations" method="POST">
                                          @csrf
                                          @method('PUT')
                                          <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label @error('registration') is-invalid @enderror">Total Registration:</label>
                                            <input type="number" name="registration" class="form-control" id="recipient-name">
                                            @error('registration')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                          </div>
                                          <button type="submit" class="btn btn-success">Update</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              @endif
                            @endif

                          </h6>

                          <h6 class="m-2">
                            Total Accreditations: {{$pu->accreditation}}

                            @if(isset(auth()->user()->role))
                              @if(strtolower(auth()->user()->role) === 'admin')

                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accreditationModal" data-bs-whatever="@getbootstrap">Update</button>

                                <div class="modal fade" id="accreditationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Accreditation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="/pus/{{$pu->id}}/accreditations" method="POST">
                                          @csrf
                                          @method('PUT')
                                          <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">Total Accreditation:</label>
                                            <input type="number" name="accreditation" class="form-control @error('accreditation') is-invalid @enderror" id="recipient-name">
                                            @error('accreditation')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                          </div>
                                          <button type="submit" class="btn btn-success">Update</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              @endif
                            @endif

                          </h6>
                        </div>
                        <div class="col-lg-3 col-md-3 label">
                           <a href="/results/{{$pu->id}}/?name={{$election}}" class="btn btn-light">View Result</a>
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