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
                  <img src="{{asset('assets/img/logo.png')}}" alt="">
                  <span class="d-none d-lg-block">Register</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create Account</h5>
                    <p class="text-center small">Enter personal details to create account</p>
                  </div>

                  <form action="/register" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf

                    <div class="col-12">
                      <label for="yourName" class="form-label">Name</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">
                          <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="name" class="form-control" id="yourName" value="{{old('name')}}" required>
                        @error('name')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">
                          <i class="bi bi-person-circle"></i>
                        </span>
                        <input type="text" name="username" class="form-control" id="yourUsername" value="{{old('username')}}" required>
                        @error('username')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email Address</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">
                          <i class="bi bi-envelope"></i>
                        </span>
                        <input type="text" name="email" class="form-control" id="yourEmail" value="{{old('email')}}" required>
                        @error('email')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">
                          <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        @error('password')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>

                    <div class="col-12">
                      <center><p class="small mb-0">Already have an account? <a href="/login">Login</a></p></center>
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