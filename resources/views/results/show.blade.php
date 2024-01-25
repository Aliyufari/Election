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

        </div>

        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">{{$election}}</button>
                </li>

              </ul>
              <div class="row">
                <div class="col-xl-12 m-3">
                  <h6 class="fw-bold">{{$result->pu->name}} - Rsut View</h6>
                </div>
                @if($result->pu->id === $result->pu_id)
                 <div class="col-xl-12 m-3e">
                      <img src="{{asset('storage/' . $result->image)}}" class="img-fluid">
                  </div>
                @else
                  <div class="col-xl-12 m-3">
                    <h6 class="" style="color:grey;">No image found yet!</h6>
                  </div>
                @endif
              </div>

              </div><!-- End Bordere2 Tabs -->

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