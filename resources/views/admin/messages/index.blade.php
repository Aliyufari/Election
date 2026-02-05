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
      <h1>Messages</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item">Messages</li>
          <li class="breadcrumb-item active">Create Message</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        
        <!-- Messages-->
            <div class="col-12">
              <div class="card top-messages overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Recent Messages</h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Author</th>
                        <th scope="col">Role</th>
                        <th scope="col">Message Title</th>
                        <th scope="col">Message Exert</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($messages as $message)
                        <tr>
                          <td>{{ $sn }}</td>
                          <td>{{ $message->user->name }}</td>
                          <td>
                            <span class="badge 
                              @if( strtolower($message->user->role) === 'user')
                                bg-warning
                              @elseif( strtolower($message->user->role) === 'admin')
                                 @php echo 'bg-info' @endphp
                              @elseif( strtolower($message->user->role) === 'ratech')
                                 @php echo 'bg-primary' @endphp
                              @else
                                @php echo 'bg-success' @endphp
                              @endif  
                            ">
                              {{ $message->user->role }}
                            </span> 
                          </td>
                          <td>{{ $message->title}}</td>
                          <td>{{ substr($message->body, 0, 24)}}</td>
                          <td scope="row" style="display: flex; align-content: flex-start; justify-content: space-between;">
                            <a href="/admin/messages/{{ $message->id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-binoculars"></i> View</a>

                            @if($message->user->id === auth()->user()->id)
                              <a href="/admin/messages/{{ $message->id }}/edit" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endif

                            <form method="POST" action="/admin/messages/{{ $message->id }}" class="form-horizontal">
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
                      {{$messages->links()}}
                    </div>

                    <div class="col-md-3">
                      <a href="/admin/messages/create" class="btn btn-primary">Create Message</a>
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