<!-- ======= Header ======= -->
@php
    $user = auth()->user();
@endphp

<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="/" class="logo d-flex align-items-center">
      <img src="{{ asset('assets/img/logo.png') }}" alt="">
      <span class="d-none d-lg-block">Admin Panel</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      @csrf
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search">
        <i class="bi bi-search"></i>
      </button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <!-- Mobile Search Icon -->
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>

      <!-- Notifications -->
      <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          @if(isset($notifications) && $notifications->count())
            <span class="badge bg-primary badge-number">
              {{ $notifications->count() }}
            </span>
          @endif
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

          <li class="dropdown-header">
            @if(isset($notifications))
              You have {{ $notifications->count() }} new notifications
            @endif
            <a href="#">
              <span class="badge rounded-pill bg-primary p-2 ms-2">
                View all
              </span>
            </a>
          </li>

          <li><hr class="dropdown-divider"></li>

          @if(isset($notifications))
            @forelse($notifications as $notification)

              <li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div>
                  <h4>{{ $notification->title }}</h4>
                  <p>{{ $notification->body }}</p>
                  <p>4 hrs. ago</p>
                </div>
              </li>

              <li><hr class="dropdown-divider"></li>

            @empty
              <li class="notification-item">
                <div>
                  <h4>You have no notification</h4>
                </div>
              </li>
              <li><hr class="dropdown-divider"></li>
            @endforelse
          @endif

          <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
          </li>

        </ul>

      </li><!-- End Notification Nav -->


      <!-- Messages (Admins only) -->
      @if($user?->role?->name === 'admin')
      <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-chat-left-text"></i>

          @if($user->messages && $user->messages->count())
            <span class="badge bg-success badge-number">
              {{ $user->messages->count() }}
            </span>
          @endif
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">

          <li class="dropdown-header">
            You have {{ $user->messages?->count() ?? 0 }} new message(s)
            <a href="#">
              <span class="badge rounded-pill bg-primary p-2 ms-2">
                View all
              </span>
            </a>
          </li>

          <li><hr class="dropdown-divider"></li>

          @forelse($user->messages ?? [] as $msg)

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-1.jpg') }}" class="rounded-circle" alt="">
                <div>
                  <h4>{{ $msg->title }}</h4>
                  <p>{{ $msg->body }}</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>

            <li><hr class="dropdown-divider"></li>

          @empty
            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-1.jpg') }}" class="rounded-circle" alt="">
                <div>
                  <h4>You have no message</h4>
                </div>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
          @endforelse

          <li class="dropdown-footer">
            <a href="#">Show all messages</a>
          </li>

        </ul>

      </li>
      @endif
      <!-- End Messages Nav -->


      <!-- Profile -->
      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

          <img
            src="{{ $user->image ? asset('storage/'.$user->image) : asset('assets/img/users/user.jpg') }}"
            alt="Profile"
            class="rounded-circle"
          >

          <span class="d-none d-md-block dropdown-toggle ps-2">
            {{ ucfirst($user?->role?->name ?? 'User') }}
          </span>

        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

          <li class="dropdown-header">
            <h6>{{ $user->name }}</h6>
            <span>{{ $user->job }}</span>
          </li>

          <li><hr class="dropdown-divider"></li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="/profile">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>

          <li><hr class="dropdown-divider"></li>

          <li>
            <a class="dropdown-item d-flex align-items-center"
               href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>

            <form id="logout-form" action="/logout" method="POST" class="d-none">
              @csrf
            </form>
          </li>

        </ul>

      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header>