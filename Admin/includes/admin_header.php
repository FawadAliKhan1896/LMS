  <?php
include('../config/db.php');
// session_start();

$admin_id = $_SESSION['user_id'] ?? 0;

$query = "SELECT * FROM users WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$profile_picture = !empty($user['profile_picture']) ? "../uploads/profile/" . $user['profile_picture'] : "../uploads/profile/profile.jpg";
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
        <img src="<?= $profile_picture ?>" alt="Picture" class="rounded-circle"  style="width:35px; height:35px; object-fit:cover; margin-right:8px;"> <span>Admin</span>
      </a>

      <div class="dropdown-menu dropdown-menu-right">
        <a href="profile.php" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
        <a href="Settings.php" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
        <div class="dropdown-divider"></div>
        <a href="../auth/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </li>
  </ul>
</nav>

  <!-- /.navbar -->