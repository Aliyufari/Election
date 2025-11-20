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
      <h1>Results</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/">Results</a></li>
          <li class="breadcrumb-item active">Result Upload</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center fw-bold">PU Result Image Upload</h3>

              <!-- Horizontal Form -->
              <form action="/admin/results/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                  <label for="pu" class="col-sm-2 col-form-label fw-bold">Polling Unit:</label>
                  <div class="col-sm-10">
                    <select name="pu_id" id="pu" class="form-select @error('pu_id') is-invalid @enderror" data-dependent="zone">
                      <option disabled>Choose PU</option>
                      @foreach($pus as $pu)
                        <option value="{{ $pu->id }}">{{ $pu->name }}</option>
                      @endforeach
                    </select>
                      @error('pu_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="election" class="col-sm-2 col-form-label fw-bold">Election Type:</label>
                  <div class="col-sm-10">
                    <select name="election_id" id="election" class="form-select @error('election_id') is-invalid @enderror">
                      <option disabled>Choose Election</option>
                      @foreach($elections as $election)
                        <option value="{{ $election->id }}">{{ $election->type }}</option>
                      @endforeach
                    </select>
                      @error('election_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="image" class="col-sm-2 col-form-label fw-bold">Result Image:</label>
                  <div class="col-sm-10">
                    <input type="file" name="image" class="form-control" id="image">
                    @error('image')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
              </form><!-- End Horizontal Form -->

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