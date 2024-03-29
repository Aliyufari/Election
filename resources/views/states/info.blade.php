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
      <h1>INEC - Accreditation Console View</h1>
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

        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"><h6 class="m-0"><strong>Election Type</strong></h6></button>
                </li>

              </ul>
              <div class="tab-content p-10">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h6 class="mt-3" style="color:grey;">Select the election type to view accreditation:</h6>
  
                  @foreach($election_list as $election)
                    <div class="row">
                      <div class="col-lg-4 col-md-6 label ">
                        <i class="bi bi-search"></i>
                        <a href="/states/{{$state->id}}/zones/?name={{$election}}">{{$election}}</a>
                      </div>
                    </div>
                  @endforeach

                </div>

              </div>

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