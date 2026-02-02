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
          <li class="breadcrumb-item">Results</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-messages overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Recent Uploaded Results</h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">PU</th>
                        <th scope="col">Election</th>
                        <th scope="col">Result Image</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($results as $result)
                        <tr>
                          <td>{{ $sn }}</td>
                          <td>{{ $result->pu->name }}</td>
                          <td>{{ $result->election->type }}</td>
                          <td>
                            <img src="{{ $result->image ? asset('storage/' . $result->image) : asset('assets/img/results/result.jpg')}}" style="max-width:40px; max-height:40px;" alt="" title="{{ $result->pu->name }} Result">
                          </td>
                          <td scope="row" style="display: flex; align-content: flex-start; justify-content: space-between;">
                            <a href="/results/{{ $result->pu_id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-binoculars"></i> View</a>

                            <a href="/admin/results/{{ $result->id }}/edit" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i> Edit</a>

                            <form method="POST" action="/admin/results/{{ $result->id }}" class="form-horizontal">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i>Delete</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <hr>
                  <div class="row mb-3">
                    <div class="col-md-9">
                      {{$results->links()}}
                    </div>

                    <div class="col-md-3">
                      <a href="/admin/results/create" class="btn btn-primary">Upload Result</a>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Top Messages -->
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