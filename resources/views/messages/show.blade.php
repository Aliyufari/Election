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
          <li class="breadcrumb-item"><a href="/admin/messages">Messages</a></li>
          <li class="breadcrumb-item active">Show Message</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title" style="">{{ $message->title}}</h5>
              <hr class="mt-0 mb-10">

              <span class="card-title mt-3" style="font-size: 16px;"><b>Send by:</b> {{ $message->user->name}}</span> - 
                <span class="badge 
                  @if( strtolower($message->user->role) === 'user')
                    bg-warning
                  @elseif( strtolower($message->user->role) === 'admin')
                     @php echo 'bg-info' @endphp
                  @elseif( strtolower($message->user->role) === 'ratech')
                     @php echo 'bg-primary' @endphp
                  @else( strtolower($message->user->role) === 'supervisor')
                    @php echo 'bg-success' @endphp
                  @endif  
                ">
                  {{ $message->user->role }}
                </span> 

              <h3 class="card-title m-0" style="margin: 5px 0; font-size: 14px;"><b>Date:</b><i  style="color:grey;"> {{ $message->created_at}}</i></h6>
              <div>
                <p class="card-title m-0"><b>Message Body:</b></p>
                <p>{{ $message->body}}</p> 
              </div>
            </div>
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