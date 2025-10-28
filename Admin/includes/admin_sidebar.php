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
    <a href="#" class="brand-link">
      <!-- <i class="fas fa-graduation-cap ml-2"></i>
      <span class="brand-text font-weight-light">Admin</span> -->
      <img src="../uploads/profile/<?= $settings['site_logo'] ?>" style="width: 230px">
    </a>
   <div class="sidebar">
      <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item"><a href="admdashboard.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="manage_course.php" class="nav-link"><i class="nav-icon fas fa-book"></i><p>Manage Course</p></a></li>
          <li class="nav-item"><a href="manage_class.php" class="nav-link"><i class="nav-icon fas fa-school"></i><p>Manage Class</p></a></li>
          <li class="nav-item"><a href="manage_user.php" class="nav-link"><i class="nav-icon fas fa-users-cog"></i><p>Manage User</p></a></li>
          <li class="nav-item"><a href="questionbank.php" class="nav-link"><i class="nav-icon fas fa-question-circle"></i><p>Question Bank</p></a></li>        
          <li class="nav-item"><a href="manage_result.php" class="nav-link"><i class="nav-icon fas fa-chart-bar"></i><p>Reports</p></a></li>
          <li class="nav-item"><a href="announcements.php" class="nav-link"><i class="nav-icon fas fa-bullhorn"></i><p>Announcements</p></a></li>
          <li class="nav-item"><a href="Settings.php" class="nav-link"><i class="nav-icon fas fa-cogs"></i><p>Page Settings</p></a></li>
          <li class="nav-item"><a href="../auth/logout.php" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Signout</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>
  <!-- /.sidebar -->