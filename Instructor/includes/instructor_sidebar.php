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
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="#" class="brand-link">
           <i class="fas fa-graduation-cap ml-2"></i>
          <span class="brand-text font-weight-light">Quiz Portal</span>
    </a> -->
    <img src="../uploads/profile/<?= $settings['site_logo'] ?>" style="width: 230px">

     <!-- Sidebar Menu -->
    <div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
            <a href="insdashboard.php" class="nav-link" data-section="dashboard">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
            </a>
        </li>
                <li class="nav-item">
            <a href="questionadd.php" class="nav-link" data-section="add-mcq">
            <i class="nav-icon fas fa-plus-circle"></i>
            <p>Add Questions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="questions.php" class="nav-link" data-section="question-bank">
            <i class="nav-icon fas fa-database"></i>
            <p>Question Bank</p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
                Announcements
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="Upload.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Upload Material</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="Task.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Task</p>
                </a>
            </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="submission.php" class="nav-link" data-section="results">
                <i class="nav-icon fas fa-file-alt"></i>
            <p>Submissions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="results.php" class="nav-link" data-section="results">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Result Analysis</p>
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