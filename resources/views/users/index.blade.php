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
      <h1>Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Manage Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- Users List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              

              <div class="card-body">
                <h5 class="card-title">Recent Users</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th >S/N &nbsp; &nbsp;</th>
                      <th scope="col">Name &nbsp; &nbsp;</th>
                      <th scope="col">Username &nbsp; &nbsp;</th>
                      <th scope="col">Email &nbsp; &nbsp;</th>
                      <th scope="col">Gender &nbsp; &nbsp;</th>
                      <th scope="col">Image &nbsp; &nbsp;</th>
                      <th scope="col">Role &nbsp; &nbsp;</th>
                      <th scope="col">Actions &nbsp; &nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $user)
                    @if( strtolower($user->role) !== 'super')
                      <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->gender }}</td>
                        <th scope="row">
                          <a href="/admin/users/{{ $user->id }}">
                            <img src="{{$user->image ? asset('storage/' . $user->image) : asset('assets/img/users/user.jpg')}}" style="max-width:40px; max-height:40px;" alt="" title="View User">
                          </a>
                        </th>
                        <td>
                          <span class="badge 
                            @if( strtolower($user->role) === 'user')
                              bg-warning
                            @elseif( strtolower($user->role) === 'admin')
                               @php echo 'bg-success' @endphp
                            @elseif( strtolower($user->role) === 'ratech')
                               @php echo 'bg-primary' @endphp
                            @else
                              @php echo 'bg-info' @endphp
                            @endif  
                          ">
                            {{ $user->role }}
                          </span>
                        </td>
                        <td scope="row" style="display: flex; align-content: flex-start; justify-content: space-between;">
                          <a href="/admin/users/{{ $user->id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-binoculars"></i> View</a>
                          <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                          <form method="POST" action="/admin/users/{{ $user->id }}" class="form-horizontal">
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
                    <a href="/admin/users/create" class="btn btn-primary">
                      <i class="bi bi-person-plus"></i> Create User
                    </a>
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
  