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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Wards</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- States List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">Recent Wards</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th >S/N &nbsp; &nbsp;</th>
                      <th scope="col">Name &nbsp; &nbsp;</th>
                      <th scope="col">State &nbsp; &nbsp;</th>
                      <th scope="col">Zone &nbsp; &nbsp;</th>
                      <th scope="col">LGA &nbsp; &nbsp;</th>
                      <th scope="col">PUs &nbsp; &nbsp;</th>
                      <th scope="col">Voters &nbsp; &nbsp;</th>
                      <th scope="col">Actions &nbsp; &nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($wards as $ward)
                      <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $ward->name }}</td>
                        <td>{{ $ward->state->name }}</td>
                        <td>{{ $ward->zone->name }}</td>
                        <td>{{ $ward->lga->name }}</td>
                        <td>{{ count($ward->pus) }}</td>
                        <td>{{ count($ward->users) }}</td>
                        <td scope="row" style="display: flex; align-content: flex-start; justify-content: space-between;">
                          <a href="/admin/wards/{{ $ward->id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-binoculars"></i> View</a>
                          <a href="/admin/wards/{{ $ward->id }}/edit" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                          <form method="POST" action="/admin/wards/{{ $ward->id }}" class="form-horizontal">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i>Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <div class="row">
                   <div class="col-md-9">
                    {{$wards->links()}}
                  </div>

                  <div class="col-md-3">
                    <a href="/admin/wards/create" class="btn btn-primary">Add Ward</a>
                  </div>
                </div>
            
              </div>

            </div>
          </div><!-- End States List -->

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