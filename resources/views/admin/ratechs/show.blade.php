@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.sidebar')
@endsection

@section('content')
    <main id="main" class="main">

    <div class="pagetitle">
      <h1>Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Show User</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">

        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Personal Details</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Contact Details</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">PU Details</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Profile Image:</div>
                    <div class="col-lg-9 col-md-8">
                      <img src="{{ asset('storage/' . $user->image)}}" style="max-width:120px;" alt="Profile">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Name:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Username:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Gender:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->gender }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Role:</div>
                    <span style="width:100px;" class="badge 
                      @if( strtolower($user->role) === 'user')
                        bg-warning
                      @elseif( strtolower($user->role) === 'admin')
                        bg-info
                      @else( strtolower($user->role) === 'super')
                        bg-success
                      @endif  
                    ">
                      {{ $user->role }}
                    </span>
                  </div>

                </div>

                <div class="tab-pane fade show profile-overview" id="profile-edit">

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Contact Address:</div>
                    <div class="col-lg-9 col-md-8"></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone Number:</div>
                    <div class="col-lg-9 col-md-8">{{ '+234' . $user->phone }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email Address:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                  </div>
                  
                </div>

                <div class="tab-pane fade profile-overview" id="profile-settings">

                 <div class="row">
                    <div class="col-lg-3 col-md-4 label">State:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->state->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Zone:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->zone }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Local Government:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->lga->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Ward:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->ward->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Polling Unit:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->pu }}</div>
                  </div> <div class="row">
                    <div class="col-lg-3 col-md-4 label">Zone:</div>
                    <div class="col-lg-9 col-md-8">
                      {{ isset($user->zone->name) ? $user->zone->name : ''}}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Local Government:</div>
                    <div class="col-lg-9 col-md-8">
                      {{ $user->lga->name }}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Ward:</div>
                    <div class="col-lg-9 col-md-8">{{ $user->ward->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Polling Unit:</div>
                    <div class="col-lg-9 col-md-8">
                      {{ isset($user->pu->name) ? $user->pu->name : ''}}
                    </div>
                  </div>
                  
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
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection
  