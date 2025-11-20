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
      <h1>LGAs Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">LGAs</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

          <!-- LGAs List -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto border-0 shadow-sm">

              <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0 text-dark fw-bold">LGAs List</h5>
                  <a href="/admin/lgas/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add New LGA
                  </a>
                </div>
                <p class="text-muted mt-2 mb-0">Manage all Local Government Areas in the system</p>
              </div>

              <div class="card-body pt-3">
                <div class="table-responsive">
                  <table class="table table-hover table-borderless">
                    <thead class="table-light">
                      <tr>
                        <th class="ps-3">S/N</th>
                        <th>Name</th>
                        <th>State</th>
                        <th>Zone</th>
                        <th>Wards</th>
                        <th>PUs</th>
                        <th>Voters</th>
                        <th class="text-center pe-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($lgas as $lga)
                        <tr class="border-bottom">
                          <td class="ps-3 fw-medium">{{ $sn++ }}</td>
                          <td class="fw-semibold text-dark">{{ $lga->name }}</td>
                          <td>
                            <span class="badge bg-secondary rounded-pill">{{ $lga->state->name }}</span>
                          </td>
                          <td>
                            <span class="badge bg-primary rounded-pill">{{ $lga->zone->name }}</span>
                          </td>
                          <td>
                            <span class="badge bg-info rounded-pill">{{ count($lga->wards) }}</span>
                          </td>
                          <td>
                            <span class="badge bg-warning rounded-pill">{{ count($lga->pus) }}</span>
                          </td>
                          <td>
                            <span class="badge bg-danger rounded-pill">{{ count($lga->users) }}</span>
                          </td>
                          <td class="text-center pe-3">
                            <div class="btn-group" role="group">
                              <a href="/admin/lgas/{{ $lga->id }}" class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                              </a>
                              <a href="/admin/lgas/{{ $lga->id }}/edit" class="btn btn-sm btn-outline-success" title="Edit">
                                <i class="bi bi-pencil"></i>
                              </a>
                              <form method="POST" action="/admin/lgas/{{ $lga->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this LGA?')">
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
                    Showing {{ $lgas->firstItem() ?? 0 }} to {{ $lgas->lastItem() ?? 0 }} of {{ $lgas->total() }} entries
                  </div>
                  <div>
                    {{ $lgas->links() }}
                  </div>
                </div>
            
              </div>

            </div>
          </div><!-- End LGAs List -->

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