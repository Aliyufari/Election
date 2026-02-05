<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/coordinator') ? 'active' : 'collapsed' }}" href="/coordinator">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/admin/state/list') ? 'active' : 'collapsed' }}" href="/admin/state/list">
          <i class="bi bi-binoculars"></i>
          <span>Accreditations</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/admin/cvr/states') ? 'active' : 'collapsed' }}" href="/admin/cvr/states">
          <i class="bi bi-people"></i>
          <span>CVR</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="">
          <i class="bi bi-check"></i>
          <span>Parties</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#cvr-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-square"></i><span>CVR Panel</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="cvr-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/admin/cvr/voters">
              <i class="bi bi-gear"></i><span>Total Registered Voters</span>
            </a>
          </li>

          <li>
            <a href="/admin/cvr/records">
              <i class="bi bi-people"></i><span>My Records</span>
            </a>
          </li>

          <li>
            <a href="/admin/cvr/logins">
              <i class="bi bi-people"></i><span>CVR Logins</span>
            </a>
          </li>

          <li>
            <a href="https://cvr.inecnigeria.org/Home/start" target="_balnk">
              <i class="bi bi-people"></i><span>Apply New CVR</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/messages*') ? 'active' : 'collapsed' }}" href="/admin/messages">
          <i class="bi bi-chat-square-text"></i>
          <span>Messages</span>
        </a>
      </li>

    </ul>

</aside>