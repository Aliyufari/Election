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
      <h1>Polling Units Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Polling Units</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- PUs List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto border-0 shadow-sm">

              <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0 text-dark fw-bold">Polling Units List</h5>
                  <a href="/admin/pus/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add New PU
                  </a>
                </div>
                <p class="text-muted mt-2 mb-0">Manage all Polling Units in the system</p>
              </div>

              <div class="card-body pt-3">
                <div class="table-responsive">
                  <table class="table table-hover table-borderless">
                    <thead class="table-light">
                      <tr>
                        <th class="ps-3">S/N</th>
                        <th>Number</th>
                        <th>Name</th>
                        <th>State</th>
                        <th>Zone</th>
                        <th>LGA</th>
                        <th>Ward</th>
                        <th>Voters</th>
                        <th class="text-center pe-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pus as $pu)
                        <tr class="border-bottom">
                          <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                          <td class="fw-semibold text-primary">{{ $pu->number }}</td>
                          <td class="fw-semibold text-dark">{{ $pu?->name }}</td>
                          <td>
                            <span class="badge bg-secondary rounded-pill">{{ $pu->state?->name }}</span>
                          </td>
                          <td>
                            <span class="badge bg-primary rounded-pill">{{ $pu->zone?->name }}</span>
                          </td>
                          <td>
                            <span class="badge bg-success rounded-pill">{{ $pu->lga?->name }}</span>
                          </td>
                          <td>
                            <span class="badge bg-info rounded-pill">{{ $pu->ward?->name }}</span>
                          </td>
                          <td>
                            <span class="badge bg-danger rounded-pill">{{ count($pu->users) }}</span>
                          </td>
                          <td class="text-center pe-3">
                            <div class="btn-group" role="group">
                              <a href="/admin/pus/{{ $pu->id }}" class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                              </a>
                              <a href="/admin/pus/{{ $pu->id }}/edit" class="btn btn-sm btn-outline-success" title="Edit">
                                <i class="bi bi-pencil"></i>
                              </a>
                              <form method="POST" action="/admin/pus/{{ $pu->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this polling unit?')">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                  <div class="text-muted small">
                    Showing {{ $pus->firstItem() ?? 0 }} to {{ $pus->lastItem() ?? 0 }} of {{ $pus->total() }} entries
                  </div>
                  <div>
                    {{ $pus->links() }}
                  </div>
                </div>
            
              </div>

            </div>
          </div>

      </div>
    </section>

  </main>

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