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
      <h1>Supervisors</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Supervisors</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- Users List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">Recent Supervisors</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th >S/N &nbsp; &nbsp;</th>
                      <th scope="col">Name &nbsp; &nbsp;</th>
                      <th scope="col">Ward &nbsp; &nbsp;</th>
                      <th scope="col">Phone &nbsp; &nbsp;</th>
                      <th scope="col">Role &nbsp; &nbsp;</th>
                      <th scope="col">Actions &nbsp; &nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                      @if( strtolower($user->role) === 'supervisor')
                        <tr>
                          <td>{{ $sn++ }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->ward->name }}</td>
                          <td>{{ $user->phone }}</td>
                          <td>
                            <span class="badge bg-info">{{ $user->role }}</span>
                          </td>
                          <td scope="row" style="display: flex; align-content: flex-start; justify-content: space-between;">
                            <a href="/admin/supervisors/{{ $user->id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-binoculars"></i> View</a>
                            <a href="/admin/supervisors/{{ $user->id }}/edit" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                            <form method="POST" action="/admin/supervisors/{{ $user->id }}" class="form-horizontal">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i>Delete</button>
                            </form>
                          </td>
                        </tr>
                      @endif 
                    @endforeach
                  </tbody>
                </table>

                <div class="row">
                  <div class="col-md-9">
                    {{$users->links()}}
                  </div>

                  <div class="col-md-3">
                    <a href="/admin/supervisors/create" class="btn btn-primary">Create Supervisor</a>
                  </div>
                </div>
            
              </div>

            </div>
          </div><!-- End Users List -->

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
  