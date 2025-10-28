<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Student') {
    header("Location: ../index.php");
    exit;
}

include('../config/db.php');

$page_title = isset($page_title) ? $page_title : "Student Dashboard";
$content = isset($content) ? $content : "stddashboard.php";

$settingsQuery = mysqli_query($conn, "SELECT * FROM page_settings LIMIT 1");
$page_settings = mysqli_fetch_assoc($settingsQuery);

$site_title = !empty($page_settings['site_title']) ? $page_settings['site_title'] : $page_title;
$favicon = !empty($page_settings['favicon']) ? '../uploads/profile/'.$page_settings['favicon'] : '../uploads/profile/default.png';
$site_logo = !empty($page_settings['site_logo']) ? '../uploads/profile/'.$page_settings['site_logo'] : '../uploads/profile/default.png';

$disable_copy = !empty($page_settings['disable_copy_paste']);
$one_tab = !empty($page_settings['one_tab_enforcement']);
$full_summary = !empty($page_settings['full_summary']);
$short_summary = !empty($page_settings['short_summary']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($site_title) ?></title>
  <link rel="icon" href="<?= $favicon ?>">


  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    html {
      scroll-behavior: smooth; /* smooth scrolling */
    }
  </style>
  <script>
<?php if($disable_copy): ?>
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.addEventListener('copy', e => e.preventDefault());
    document.addEventListener('cut', e => e.preventDefault());
    document.addEventListener('paste', e => e.preventDefault());
});
<?php endif; ?>

<?php if($one_tab): ?>
if(localStorage.getItem('lms_tab_locked')){
    alert('Another tab is already open. Please use that tab.');
    window.close();
} else {
    localStorage.setItem('lms_tab_locked', 'true');
}
window.addEventListener('beforeunload', function() {
    localStorage.removeItem('lms_tab_locked');
});
<?php endif; ?>

let fullSummary = <?= $full_summary ? 'true' : 'false' ?>;
let shortSummary = <?= $short_summary ? 'true' : 'false' ?>;

document.addEventListener('DOMContentLoaded', () => {
    if(fullSummary){
        document.querySelectorAll('.summary-short').forEach(el => el.style.display='none');
        document.querySelectorAll('.summary-full').forEach(el => el.style.display='block');
    }
    if(shortSummary){
        document.querySelectorAll('.summary-full').forEach(el => el.style.display='none');
        document.querySelectorAll('.summary-short').forEach(el => el.style.display='block');
    }
});
</script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include('includes/student_header.php'); ?>


  <?php include('includes/student_sidebar.php'); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Dashboard -->
    <section class="content" id="dashboard-section">
      <?php include($content); ?>
    </section>
    <!-- /Dashboard -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('includes/student_footer.php'); ?>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/yourusername/yourrepo/auto-year.js"></script>

</body>
</html>
