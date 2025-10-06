<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/') ? 'active' : 'collapsed' }}" href="/">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/states*') ? 'active' : 'collapsed' }}" href="/admin/states">
          <i class="bi bi-house"></i><span>States</span>
        </a>
      </li><!-- End States Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/zones*') ? 'active' : 'collapsed' }}" href="/admin/zones">
          <i class="bi bi-geo-alt"></i><span>Zones</span>
        </a>
      </li><!-- End Zones Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/lgas*') ? 'active' : 'collapsed' }}" href="/admin/lgas">
          <i class="bi bi-shop"></i><span>LGAs</span>
        </a>
      </li><!-- End LGAs Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/wards*') ? 'active' : 'collapsed' }}" href="/admin/wards">
          <i class="bi bi-collection"></i><span>Wards</span>
        </a>
      </li><!-- End Wards Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/pus*') ? 'active' : 'collapsed' }}" href="/admin/pus">
          <i class="bi bi-pin-map"></i><span>Polling Units</span>
        </a>
      </li><!-- End Polling Units Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/elections*') ? 'active' : 'collapsed' }}" href="/admin/elections">
          <i class="bi bi-mailbox"></i><span>Election</span>
        </a>
      </li><!-- End Election Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/supervisors*') ? 'active' : 'collapsed' }}" href="/admin/supervisors">
          <i class="bi bi-person-circle"></i>
          <span>Supervisors</span>
        </a>
      </li><!-- End Supervisors Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/ratechs*') ? 'active' : 'collapsed' }}" href="/admin/ratechs">
          <i class="bi bi-person-square"></i>
          <span>Ratechs</span>
        </a>
      </li><!-- End Ratechs Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : 'collapsed' }}" href="/admin/users">
          <i class="bi bi-person"></i>
          <span>Manage Users</span>
        </a>
      </li><!-- End Users Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/messages*') ? 'active' : 'collapsed' }}" href="/admin/messages">
          <i class="bi bi-chat-square-text"></i>
          <span>Messages</span>
        </a>
      </li><!-- End Messages Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/results*') ? 'active' : 'collapsed' }}" href="/admin/results">
          <i class="bi bi-file-earmark-arrow-up"></i>
          <span>Results</span>
        </a>
      </li><!-- End Results Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : 'collapsed' }}" href="/admin/settings">
          <i class="bi bi-sliders"></i>
          <span>Settings</span>
        </a>
      </li><!-- End Settings Nav -->

    </ul>

</aside><!-- End Sidebar-->