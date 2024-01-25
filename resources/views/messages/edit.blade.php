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
      <h1>Messages</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item">Messages</li>
          <li class="breadcrumb-item active">Edit Message</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Edit Message</h3>

              <!-- Horizontal Form -->
              <form action="/admin/messages/{{ $msg->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                  <label for="title" class="col-sm-2 col-form-label">Message Title</label>
                  <div class="col-sm-10">
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $msg->title }}" placeholder="Message Title">
                    @error('title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="body" class="col-sm-2 col-form-label">Message Body</label>
                  <div class="col-sm-10">
                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="body" placeholder="Message Body">{{ $msg->body }}</textarea>
                    @error('body')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </form><!-- End Horizontal Form -->

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