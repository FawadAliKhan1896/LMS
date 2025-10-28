<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <!-- Profile Picture Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
        <!-- Profile Image -->
               <img src="/Profile.jpg" alt="Picture" class="rounded-circle"  style="width:35px; height:35px; object-fit:cover; margin-right:8px;"> <span> Instructor </span>
      </a>

      <div class="dropdown-menu dropdown-menu-right">
        <a href="profile.php" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
        <div class="dropdown-divider"></div>
        <a href="../auth/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </li>
  </ul>
</nav>