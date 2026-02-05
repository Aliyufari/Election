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
          <li class="breadcrumb-item">Manage Records</li>
          <li class="breadcrumb-item active">Create State</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Create Zone</h2>

              <!-- No Labels Form -->
              <form action="/admin/zones/{{ $zone->id }}" method="POST" class="row g-3" style="font-size: 14px;">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                  <label for="name" class="form-label fw-bold">Name:</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $zone->name }}" placeholder="Enter State's Name">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="state" class="form-label fw-bold">Zone's State:</label>
                  <select name="state_id" id="state" class="form-select @error('state') is-invalid @enderror">
                    <option disabled>Choose State</option>
                    @foreach($states as $state)
                      <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                  </select>
                  @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                 <div class="col-md-12">
                  <label for="description" class="form-label fw-bold">Description:</label>
                  <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"  placeholder="Type Descrition">{{ $zone->description }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div> 

                <div class="text-left">
                  <button type="submit" class="btn btn-success">Update</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>

              </form>
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