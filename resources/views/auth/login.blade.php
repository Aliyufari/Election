@extends('layouts.app')

@section('content')
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="{{asset('assets/img/logo.png')}}" style="height: ; width: ;" alt="">
                  <span class="d-none d-lg-block">Login</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login here</h5>
                    <p class="text-center small">You must be logged in to access content.</p>
                  </div>

                  <form action="{{ route('login') }}" method="POST" class="row g-3 needs-validation" novalidate>
                    
                    @csrf

                    <div class="col-12">
                      <div class="input-group @error('username') is-invalid @enderror">
                        <span class="input-group-text" id="inputGroupPrepend">
                        	<i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                        @error('username')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12 mb-3">
                      <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend">
                        	<i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control @error('username') is-invalid @enderror" id="password" placeholder="Password" required>
                        @error('password')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="row">
                     <span class="col-6">Unable to login?</span>
                     <a href="#" class="col-6">Reset Password</a>
                    </div>

                    <div class="col-6">
                      @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                      @endif
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <!-- <center><p class="small mb-0">Don't have an account? <a href="/register">Register</a></p></center> -->
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
@endsection('content')

@section('toast')
  @include('partials.toast')
@endsection