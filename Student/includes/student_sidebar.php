<?php
include('../config/db.php');
// session_start();

$settings_query = mysqli_query($conn, "SELECT * FROM page_settings LIMIT 1");
if (mysqli_num_rows($settings_query) == 0) {
    mysqli_query($conn, "INSERT INTO page_settings (site_title, site_logo, favicon, browse_lock, disable_copy_paste, one_tab_enforcement, full_summary, short_summary) 
                        VALUES ('My LMS', 'default_logo.png', 'default_favicon.png', 0,0,0,0,0)");
    $settings_query = mysqli_query($conn, "SELECT * FROM page_settings LIMIT 1");
}
$settings = mysqli_fetch_assoc($settings_query);
?>
<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <!-- <a href="#" class="brand-link">
    <i class="fas fa-user-graduate ml-2"></i>
    <span class="brand-text font-weight-light">Student Portal</span>
  </a> -->
  <img src="../uploads/profile/<?= $settings['site_logo'] ?>" style="width: 230px">

  <!-- Sidebar Menu -->
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="stddashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
         <li class="nav-item">
          <a href="material.php" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Study Material</p>
          </a>
        </li>
         <li class="nav-item">
          <a href="submission.php" class="nav-link">
            <i class="nav-icon fas fa-upload"></i>
            <p>Submissions</p>
          </a>
        </li>
        <li class="nav-item">
            <li class="nav-item">
        <a href="myexams.php" class="nav-link">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>Exams</p>
        </a>
      </li>
        </li>
        <li class="nav-item">
          <a href="results.php" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>My Results</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../auth/logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>