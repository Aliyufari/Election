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
      <h1>Form Layouts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Manage Records</li>
          <li class="breadcrumb-item active">Create PU</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Create PU</h2>

              <!-- No Labels Form -->
              <form action="/admin/pus/create" method="POST" class="row g-3" style="font-size: 14px;">
                @csrf
                <div class="col-md-6">
                  <label for="number" class="form-label fw-bold">Number:</label>
                  <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" id="number" value="{{ old('number') }}" placeholder="Enter PU's Number">
                  @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                 <div class="col-md-6">
                  <label for="name" class="form-label fw-bold">Name:</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Enter PU's Name">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="state" class="form-label fw-bold">PU's State:</label>
                  <select name="state_id" id="state" class="form-select @error('state') is-invalid @enderror dynamic" data-dependent="zone">
                    <option disabled>Choose State</option>
                    @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                  </select>
                  @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="zone" class="form-label fw-bold">PU's Zone:</label>
                  <select name="zone_id" id="zone" class="form-select @error('zone') is-invalid @enderror dynamic" data-dependent="lga">
                    <option disabled>Choose Zone</option>
                  </select>
                  @error('zone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="lga" class="form-label fw-bold">PU's LGA:</label>
                  <select name="lga_id" id="lga" class="form-select @error('lga') is-invalid @enderror dynamic" data-dependent="ward">
                    <option disabled>Choose LGA</option>
                  </select>
                  @error('lga')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="ward" class="form-label fw-bold">PU's Ward:</label>
                  <select name="ward_id" id="ward" class="form-select @error('ward') is-invalid @enderror">
                    <option disabled>Choose Ward</option>
                  </select>
                  @error('ward')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                 <div class="col-md-12">
                  <label for="description" class="form-label fw-bold">Description:</label>
                  <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"  placeholder="Type Descrition">{{ old('description') }}</textarea>
                  @error('description')
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