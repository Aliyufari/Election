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
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="{{auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/img/users/user.jpg')}}" alt="Profile" class="rounded-circle">
              <h2>{{ auth()->user()->name }}</h2>
              <h3>{{ auth()->user()->job }}</h3>
              <div class="social-links mt-2">
                <a href="{{ auth()->user()->twitter }}" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="{{ auth()->user()->facebook }}" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="{{ auth()->user()->instagram }}" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="{{ auth()->user()->youtube }}" class="youtube"><i class="bi bi-youtube"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">{{ auth()->user()->description }}</p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Username</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->username }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->company }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->job }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->country }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->address }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">{{ "+234" . auth()->user()->phone }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="/profile/{{auth()->user()->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="/{{auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/img/users/user.jpg')}}" id="profile" name="image" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" id="upload" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <input type="file" name="image" id="image" style="display:none;">
                          <a href="#" class="btn btn-danger btn-sm" id="remove"  title="Remove my profile image"><i class="bi bi-trash"></i></a>

                          @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror

                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="fullName" value="{{ auth()->user()->name }}">
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                     <div class="row mb-3">
                      <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ auth()->user()->username }}">
                        @error('username')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                      <div class="col-md-8 col-lg-9">
                        <select name="gender" class="form-control" id="gender">
                          <option disabled>Choose Gender</option>
                          <option>Male</option>
                          <option>Female</option>
                          <option>Other</option>
                        </select>
                        @error('gender')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="about" style="height: 100px">{{ auth()->user()->description }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                       
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" class="form-control @error('company') is-invalid @enderror" id="company" value="{{ auth()->user()->company }}">
                        @error('company')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="job" type="text" class="form-control @error('job') is-invalid @enderror" id="Job" value="{{ auth()->user()->job }}">
                        @error('job')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" class="form-control @error('country') is-invalid @enderror" id="Country" value="{{ auth()->user()->country }}">
                        @error('country')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="Address" value="{{ auth()->user()->address }}">
                        @error('address')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="Phone" value="{{ auth()->user()->phone }}">
                        @error('phone')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="Email" value="{{ auth()->user()->email }}">
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" class="form-control @error('twitter') is-invalid @enderror" id="Twitter" value="{{ auth()->user()->twitter }}">
                        @error('twitter')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" id="Facebook" value="{{ auth()->user()->facebook }}">
                         @error('facebook')
                          <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" class="form-control @error('instagram') is-invalid @enderror" id="Instagram" value="{{ auth()->user()->instagram }}">
                        @error('instagram')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="youtube" class="col-md-4 col-lg-3 col-form-label">Youtube Channel</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="youtube" type="text" class="form-control @error('youtube') is-invalid @enderror" id="youtube" value="{{ auth()->user()->youtube }}">
                        @error('youtube')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="/update/{{auth()->user()->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror target" id="currentPassword">
                        @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control @error('newpassword') is-invalid @enderror target" id="newPassword">
                        @error('newpassword')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control @error('renewpassword') is-invalid @enderror target" id="renewPassword">
                        @error('renewpassword')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-4 col-lg-3 ">
                      </div>
                      <div class="col-md-8 col-lg-9 m-0">
                        <input type="checkbox" class="" id="show">
                        <span> Show password</span>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                  <script>
                    let profile = document.getElementById('profile');
                    let upload = document.getElementById('upload');
                    let image = document.getElementById('image');
                    let remove = document.getElementById('remove');

                    let passwords = document.getElementsByClassName('target');
                    let show = document.getElementById('show');

                    upload.addEventListener('click', ()=> {
                      image.click();
                    });

                    image.addEventListener('change', ()=>{

                      const file = image.files[0];

                      if (file) {
                        const reader = new FileReader();
                        reader.onload = ()=>{

                          const result = reader.result;

                          profile.src = result;
                        }
                        reader.readAsDataURL(file);
                      }
                    }); 

                    remove.addEventListener('click', ()=> {
                      profile.src = "{{asset('assets/img/users/user.jpg')}}";
                    }); 

                    show.addEventListener('click', ()=> {
                      for(i=0; i<passwords.length; i++){
                        if (show.checked) {
                          passwords[i].type = 'text';
                        }else{
                          passwords[i].type = 'password';
                        }
                      }
                    });            
                  </script>

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
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