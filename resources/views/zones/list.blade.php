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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Election Type</button>
                </li>

              </ul>
              <div class="tab-content p-10">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h6 class="mt-3" style="color:grey;">Select election to view accreditation:</h6>
                  <div class="row">
                    @if(isset($zones))
                      @foreach($zones as $zone)
                        <div class="col-lg-12 col-md-12 label ">
                          <i class="bi bi-search"></i>
                          <a href="/zones/{{$zone->id}}/info">{{$zone->name}}</a>
                        </div>
                      @endforeach
                    @endif
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