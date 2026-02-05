@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('sidebar')
  @include('partials.admin.sidebar')
@endsection

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Layouts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Manage Users</li>
          <li class="breadcrumb-item active">Create User</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Create User</h2>

              <!-- No Labels Form -->
              <form action="/admin/users/create" method="POST" enctype="multipart/form-data" class="row g-3" style="font-size: 14px;">
                @csrf
                <div class="col-md-6">
                  <label for="name" class="form-label fw-bold">Full Name:</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Enter Name">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>                
                <div class="col-md-6">
                  <label for="username" class="form-label fw-bold">Username:</label>
                  <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" placeholder="Create Username">
                  @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label fw-bold">Email Address:</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Email Address">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="password" class="form-label fw-bold">Password:</label>
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{ old('password') }}" placeholder="Create Password">
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="gender" class="form-label fw-bold">Gender:</label>
                  <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                    <option disabled>Choose Gender</option>
                    <option selected>Female</option>
                    <option>Male</option>
                    <option>Other</option>
                  </select>
                  @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label fw-bold">Phone Number:</label>
                  <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number">
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="profile" class="form-label fw-bold">Profile Image:</label>
                  <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="profile">
                  @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="role" class="form-label fw-bold">Role:</label>
                  <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                    <option disabled>Choose Role</option>
                    <option>Admin</option>
                    <option>Ratech</option>
                    <option>Supervisor</option>
                    <option selected>User</option>
                  </select>
                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="state_id" class="form-label fw-bold">State:</label>
                  <select name="state_id" id="state_id" class="form-select @error('role') is-invalid @enderror dynamic" data-dependent="zone">
                    <option disabled selected>Choose State</option>
                    @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                  </select>
                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="zone" class="form-label fw-bold">State Zone:</label>
                  <select name="zone_id" id="zone" class="form-select @error('zone') is-invalid @enderror dynamic" data-dependent="lga">
                    <option disabled>Choose LGA</option>
                  </select>
                  @error('zone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="lga" class="form-label fw-bold">Local Government:</label>
                  <select name="lga_id" id="lga" class="form-select @error('lga') is-invalid @enderror dynamic" data-dependent="ward">
                    <option disabled>Choose LGA</option>
                  </select>
                  @error('lga')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="ward" class="form-label fw-bold">Registered Ward:</label>
                  <select name="ward_id" id="ward" class="form-select @error('ward') is-invalid @enderror dynamic" data-dependent="pu">
                    <option disabled>Choose Ward</option>
                  </select>
                  @error('ward')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="pu" class="form-label fw-bold">Polling Unit:</label>
                  <select name="pu_id" id="pu" class="form-select @error('pu') is-invalid @enderror">
                    <option disabled>Choose PU</option>
                  </select>
                  @error('pu')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="text-left">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End No Labels Form -->
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