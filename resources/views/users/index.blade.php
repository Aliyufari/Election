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
      <h1>Users Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- Users List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto border-0 shadow-sm">

              <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0 text-dark fw-bold">Users List</h5>
                  <a href="/admin/users/create" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Create User
                  </a>
                </div>
                <p class="text-muted mt-2 mb-0">Manage all users in the system</p>
              </div>

              <div class="card-body pt-3">
                <div class="table-responsive">
                  <table class="table table-hover table-borderless">
                    <thead class="table-light">
                      <tr>
                        <th class="ps-3">#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Image</th>
                        <th>Role</th>
                        <th class="text-center pe-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                      @if(strtolower($user->role) !== 'super')
                        <tr class="border-bottom">
                          <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                          <td class="fw-semibold text-dark">{{ $user->name }}</td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                            <span class="badge bg-secondary rounded-pill">{{ $user->gender }}</span>
                          </td>
                          <td>
                            <a href="/admin/users/{{ $user->id }}">
                              <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/img/users/user.jpg') }}" 
                                   style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" 
                                   alt="{{ $user->name }}" 
                                   title="View {{ $user->name }}">
                            </a>
                          </td>
                          <td>
                            <span class="badge 
                              @if(strtolower($user->role) === 'user')
                                bg-warning
                              @elseif(strtolower($user->role) === 'admin')
                                bg-success
                              @elseif(strtolower($user->role) === 'ratech')
                                bg-primary
                              @else
                                bg-info
                              @endif  
                            rounded-pill">
                              {{ $user->role }}
                            </span>
                          </td>
                          <td class="text-center pe-3">
                            <div class="btn-group" role="group">
                              <a href="/admin/users/{{ $user->id }}" class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                              </a>
                              <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-outline-success" title="Edit">
                                <i class="bi bi-pencil"></i>
                              </a>
                              <form method="POST" action="/admin/users/{{ $user->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      @endif 
                    @endforeach
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                  <div class="text-muted small">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
                  </div>
                  <div>
                    {{ $users->links() }}
                  </div>
                </div>
            
              </div>

            </div>
          </div><!-- End Users List -->

      </div>
    </section>

  </main><!-- End #main -->

  <style>
    .table > :not(caption) > * > * {
      padding: 0.75rem 0.5rem;
    }
    .btn-group .btn {
      margin: 0 2px;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.02);
    }
  </style>
@endsection

@section('footer')
  @include('partials.footer')
@endsection

@section('toast')
  @include('partials.toast')
@endsection