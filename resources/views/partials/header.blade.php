======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Admin Panel</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
          
          <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-bell"></i>
              @if(isset($notifications) && $notifications->count() !== 0 )
                 <span class="badge bg-primary badge-number">{{count($notifications)}}</span>
              @endif 
            </a><!-- End Notification Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
              <li class="dropdown-header">
                @if(isset($notifications))
                  You have {{count($notifications)}} new notifications
                @endif
                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
             
               @if(isset($notifications))
                 @forelse($notifications as $notification)
                  <li class="notification-item">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div>
                      <h4>{{$notification->title}}</h4>
                      <p>{{$notification->body}}</p>
                      <p>4 hrs. ago</p>
                    </div>
                  </li>

                  <li>
                    <hr class="dropdown-divider">
                  </li>
                @empty
                   <li class="notification-item">
                      <div>
                        <h4>You have no notification</h4>
                      </div>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                @endforelse
              @endif

              <li class="dropdown-footer">
                <a href="#">Show all notifications</a>
              </li>

            </ul><!-- End Notification Dropdown Items -->

          </li><!-- End Notification Nav -->
        

        @if(strtolower(auth()->user()->role) === 'admin')
          <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-chat-left-text"></i>
              @if(auth()->user()->messages)
                <span class="badge bg-success badge-number">{{count(auth()->user()->messages)}}</span>
              @endif
            </a><!-- End Messages Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
              <li class="dropdown-header">
                You have {{count(auth()->user()->messages)}} new message(s)
                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
            
              @forelse(auth()->user()->messages as $msg)
                <li class="message-item">
                  <a href="#">
                    <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                    <div>
                      <h4>{{$msg->title}}</h4>
                      <p>{{$msg->body}}</p>
                      <p>4 hrs. ago</p>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              @empty
                <li class="message-item">
                  <a href="#">
                    <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                    <div>
                      <h4>You have no message</h4>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              @endforelse

              <li class="dropdown-footer">
                <a href="#">Show all messages</a>
              </li>
            </ul><!-- End Messages Dropdown Items -->
          @endif

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/img/users/user.jpg')}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ucfirst(auth()->user()->role)}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            
            <li class="dropdown-header">
              @if(isset(auth()->user()->name))
                <h6>{{auth()->user()->name}}</h6>
              @endif
              <span>{{auth()->user()->job}}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/profile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="" 
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();
              ">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
              <form id="logout-form" action="/logout" method="POST" class="d-none">
                  @csrf
              </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header