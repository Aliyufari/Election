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
        <a class="nav-link {{ request()->is('/coordinator/cvr/records') ? 'active' : 'collapsed' }}" href="/coordinator/cvr/records">
          <i class="bi bi-record"></i>
          <span>My Records</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/coordinator/cvr/logins') ? 'active' : 'collapsed' }}" href="/coordinator/cvr/logins">
          <i class="bi bi-people"></i>
          <span>CVR Logins</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/coordinator/cvr/logins') ? 'inactive' : 'collapsed' }}" href="https://cvr.inecnigeria.org/Home/start">
          <i class="bi bi-person"></i>
          <span>Apply New CVR</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('coordinator/messages*') ? 'active' : 'collapsed' }}" href="/coordinator/messages">
          <i class="bi bi-chat-square-text"></i>
          <span>Messages</span>
        </a>
      </li>

    </ul>

</aside>