  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-house"></i><span>States</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          @if(isset(auth()->user()->name))
            @if(strtolower(auth()->user()->role) === 'admin')
              <li>
                <a href="/admin/states">
                  <i class="bi bi-binoculars"></i><span>View States</span>
                </a>
              </li>
            @endif
          @endif

          @if(isset($states))
            @foreach($states as $state)
            <li>
              <a href="/states/{{$state->id}}/info">
                <i class="bi bi-circle"></i><span>{{$state->name}}</span>
              </a>
            </li>
            @endforeach
          @endif

        </ul>
      </li><!-- End Components Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-geo-alt"></i><span>Zones</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          @if(isset(auth()->user()->name))
            @if(strtolower(auth()->user()->role) === 'admin')
              <li>
                <a href="/admin/zones">
                  <i class="bi bi-binoculars"></i><span>View Zones</span>
                </a>
              </li>
            @endif
          @endif

          @if(isset($zones))
            @foreach($zones as $zone)
            <li>
              <a href="/zones/{{$zone->id}}/lgas">
                <i class="bi bi-circle"></i><span>{{$zone->name}}</span>
              </a>
            </li>
            @endforeach
          @endif

        </ul>
      </li><!-- End Tables Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-shop"></i><span>Local Governments</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          @if(isset(auth()->user()->name))
            @if(strtolower(auth()->user()->role) === 'admin')
              <li>
                <a href="/admin/lgas">
                  <i class="bi bi-binoculars"></i><span>View LGAs</span>
                </a>
              </li>
            @endif
          @endif

          @if(isset($lgas))
            @foreach($lgas as $lga)
            <li>
              <a href="">
                <i class="bi bi-circle"></i><span>{{$lga->name}}</span>
              </a>
            </li>
            @endforeach
          @endif

        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-collection"></i><span>Wards</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          @if(isset(auth()->user()->name))
            @if(strtolower(auth()->user()->role) === 'admin')
              <li>
                <a href="/admin/wards">
                  <i class="bi bi-binoculars"></i><span>View Wards</span>
                </a>
              </li>
            @endif
          @endif

          @if(isset($wards))
            @foreach($wards as $ward)
            <li>
              <a href="">
                <i class="bi bi-circle"></i><span>{{$ward->name}}</span>
              </a>
            </li>
            @endforeach
          @endif
  
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-pin-map"></i><span>Polling Units</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          
          @if(isset(auth()->user()->name))
            @if(strtolower(auth()->user()->role) === 'admin')
              <li>
                <a href="/admin/pus">
                  <i class="bi bi-binoculars"></i><span>View PUs /  RAs</span>
                </a>
              </li>
            @endif
          @endif

          @if(isset($pus))
            @foreach($pus as $pu)
            <li>
              <a href="">
                <i class="bi bi-circle"></i><span>{{$pu->name}}</span>
              </a>
            </li>
            @endforeach
          @endif

        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-mailbox"></i><span>Election</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         @if(isset(auth()->user()->name))
            @if(strtolower(auth()->user()->role) === 'admin')
              <li>
                <a href="/admin/elections">
                  <i class="bi bi-binoculars"></i><span>View Elections</span>
                </a>
              </li>
            @endif
          @endif

          @if(isset($elections))
            @foreach($elections as $election)
            <li>
              <a href="">
                <i class="bi bi-circle"></i><span>{{$election->type}}</span>
              </a>
            </li>
            @endforeach
          @endif
        </ul>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/supervisors">
          <i class="bi bi-person-circle"></i>
          <span>Supervisors</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/ratechs">
          <i class="bi bi-person-square"></i>
          <span>Ratechs</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/users">
          <i class="bi bi-person"></i>
          <span>Manage Users</span>
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/messages">
          <i class="bi bi-chat-square-text"></i>
          <span>Messages</span>
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/results">
          <i class="bi bi-file-earmark-arrow-up"></i>
          <span>Results</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="">
          <i class="bi bi-sliders"></i>
          <span>Settings</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->