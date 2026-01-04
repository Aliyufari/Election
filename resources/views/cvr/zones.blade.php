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
      <h1 class="fst-italic fw-bolder mb-1">Welcome!</h1>
      <p class="text-muted lh-base">
    This is {{ $state->name }} State INEC Continuous Registration Update.
    <br/>
    You can find out the number of registrants as New Registrants and Previously Registered voters.
  </p>
    </div>

    <section class="section profile">
      <div class="row">

        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"><h6 class="m-0"><strong>{{ $state->name }} State Zones</strong></h6></button>
                </li>

              </ul>
              <div class="tab-content p-10">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h6 class="mt-3" style="color:grey;">Select zone to view CVR Registration:</h6>
                  <div class="row">
                    @if(isset($zones))
                        @foreach($zones as $zone)
                        <div class="col-lg-12 col-md-12 label mb-2">
                          <i class="bi bi-geo-alt"></i>
                          <a href="/admin/states/{{$state->id}}/zones/{{$zone->id}}/cvr">{{$zone->name}}</a>
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