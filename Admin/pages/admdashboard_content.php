<?php
include('../config/db.php'); 

$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$activeTests = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM quizzes WHERE status='Active'"))['total'];
$totalQuestions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM questions"))['total'];
$completedTests = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT quiz_id) AS total FROM quiz_submissions"))['total'];

$announcementsQuery = mysqli_query($conn, "SELECT * FROM announcements ORDER BY id DESC LIMIT 3");


$recentActivities = [];
$usersActivity = mysqli_query($conn, "SELECT name AS title, created_at, 'New User Registered' AS activity, 'fa-user-plus text-success' AS icon FROM users ORDER BY id DESC LIMIT 2");
$quizActivity = mysqli_query($conn, "SELECT quiz_title AS title, created_at, 'New Quiz Added' AS activity, 'fa-question text-warning' AS icon FROM quizzes ORDER BY id DESC LIMIT 2");
$taskActivity = mysqli_query($conn, "SELECT title AS title, created_at, 'New Task Created' AS activity, 'fa-clipboard-check text-info' AS icon FROM tasks ORDER BY id DESC LIMIT 2");

while ($row = mysqli_fetch_assoc($usersActivity)) $recentActivities[] = $row;
while ($row = mysqli_fetch_assoc($quizActivity)) $recentActivities[] = $row;
while ($row = mysqli_fetch_assoc($taskActivity)) $recentActivities[] = $row;

usort($recentActivities, function($a, $b) {
  return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$recentActivities = array_slice($recentActivities, 0, 5);
?>

<div class="container-fluid pt-3">
  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $totalUsers ?></h3>
          <p>Total Users</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $activeTests ?></h3>
          <p>Active Tests</p>
        </div>
        <div class="icon"><i class="fas fa-clipboard-list"></i></div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $totalQuestions ?></h3>
          <p>Total Questions</p>
        </div>
        <div class="icon"><i class="fas fa-question-circle"></i></div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $completedTests ?></h3>
          <p>Completed Tests</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>
  </div>

  <!-- Announcements + Activity -->
  <div class="row">
    <!-- Announcements -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title"><i class="fas fa-bullhorn"></i> Admin Announcements</h5>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <?php if (mysqli_num_rows($announcementsQuery) > 0): ?>
              <?php while ($a = mysqli_fetch_assoc($announcementsQuery)): ?>
                <li class="list-group-item">
                  <i class="fas fa-circle text-primary"></i>
                  <strong><?= htmlspecialchars($a['title']); ?></strong> - <?= htmlspecialchars($a['description']); ?>
                  <br><small class="text-muted"><?= date('d M Y', strtotime($a['date'])); ?></small>
                </li>
              <?php endwhile; ?>
            <?php else: ?>
              <li class="list-group-item text-muted">No announcements yet.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title"><i class="fas fa-bolt"></i> Recent Activity</h5>
        </div>
        <div class="card-body">
          <ul class="list-unstyled">
            <?php if (!empty($recentActivities)): ?>
              <?php foreach ($recentActivities as $activity): ?>
                <li>
                  <i class="fas <?= $activity['icon']; ?>"></i>
                  <?= htmlspecialchars($activity['activity']); ?> – 
                  <b><?= htmlspecialchars($activity['title']); ?></b>
                  <br><small class="text-muted"><?= date('d M Y h:i A', strtotime($activity['created_at'])); ?></small>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="text-muted">No recent activities yet.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
