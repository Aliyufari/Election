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
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Zones</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- States List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">Recent Zones</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th >S/N &nbsp; &nbsp;</th>
                      <th scope="col">Name &nbsp; &nbsp;</th>
                      <th scope="col">State &nbsp; &nbsp;</th>
                      <th scope="col">LGAs &nbsp; &nbsp;</th>
                      <th scope="col">PUs &nbsp; &nbsp;</th>
                      <th scope="col">Wards &nbsp; &nbsp;</th>
                      <th scope="col">Voters &nbsp; &nbsp;</th>
                      <th scope="col">Actions &nbsp; &nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($zones as $zone)
                      <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $zone->name }}</td>
                        <td>{{ $zone->state->name }}</td>
                        <td>{{ count($zone->lgas) }}</td>
                        <td>{{ count($zone->pus) }}</td>
                        <td>{{ count($zone->wards) }}</td>
                        <td>{{ count($zone->users) }}</td>
                        <td scope="row" style="display: flex; align-content: flex-start; justify-content: space-between;">
                          <a href="/admin/zones/{{ $zone->id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-binoculars"></i> View</a>
                          <a href="/admin/zones/{{ $zone->id }}/edit" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                          <form method="POST" action="/admin/zones/{{ $zone->id }}" class="form-horizontal">
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
                    {{$zones->links()}}
                  </div>

                  <div class="col-md-3">
                    <a href="/admin/zones/create" class="btn btn-primary">Add Zone</a>
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