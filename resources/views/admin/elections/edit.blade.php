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
          <li class="breadcrumb-item active">Create Election</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Edit Election</h2>

              <!-- No Labels Form -->
              <form action="/admin/elections/{{$election->id}}" method="POST" class="row g-3" style="font-size: 14px;">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                  <label for="type" class="form-label fw-bold">Election Type:</label>
                  <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                    <option disabled>Choose Election</option>
                    @foreach($election_list as $value)
                      <option
                        @if($election->type == $value)
                          @php echo"selected"; @endphp
                        @endif
                      >{{$value}}</option>
                    @endforeach
                  </select>
                  @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="date" class="form-label fw-bold">Election's Date:</label>
                  <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{$election->date}}">
                  @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="text-left">
                  <button type="submit" class="btn btn-success">Update</button>
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