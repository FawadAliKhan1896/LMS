<?php
include('../config/db.php');
// session_start();

$admin_id = $_SESSION['user_id'] ?? 0;

$query = "SELECT * FROM users WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$profile_picture = !empty($user['profile_picture']) ? "../uploads/profile/" . $user['profile_picture'] : "../uploads/profile/profile.jpg";

if (isset($_POST['update_profile'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    if (!empty($_FILES['profile_picture']['name'])) {
        $file_name = time() . '_' . basename($_FILES['profile_picture']['name']);
        $target_path = "../uploads/profile/" . $file_name;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path);

        $update = "UPDATE users SET name='$fullName', email='$email', mobile_no='$phone', profile_picture='$file_name' WHERE id='$admin_id'";
    } else {
        $update = "UPDATE users SET name='$fullName', email='$email', mobile_no='$phone' WHERE id='$admin_id'";
    }

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
        exit;
    }
}

if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    $check = mysqli_query($conn, "SELECT password FROM users WHERE id='$admin_id'");
    $data = mysqli_fetch_assoc($check);

    if ($data && md5($current_pass) === $data['password']) {
        if ($new_pass === $confirm_pass) {
            $hashed = md5($new_pass);
            mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE id='$admin_id'");
            echo "<script>alert('Password updated successfully!'); window.location.href='profile.php';</script>";
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Incorrect current password!');</script>";
    }
}
?>

<!-- ================== HTML + CSS =================== -->
<style>
  body { background: #f4f6f9; }

  .profile-card {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 30px;
  }

  .profile-img {
    width: 130px;
    height: 130px;
    object-fit: cover;
    border-radius: 80%;
    border: 3px solid #28a745;
    margin-bottom: 15px;
  }

  .edit-btn {
    font-size: 14px;
    padding: 8px 12px;
  }
</style>

<div class="profile-card text-center">
  <img src="<?= $profile_picture ?>" alt="Profile Picture" class="profile-img" id="profileImage">
  <h3 id="userName"><?= htmlspecialchars($user['name']) ?></h3>
  <p class="text-muted" id="userRole"><?= ucfirst($user['role']) ?></p>

  <hr>

  <!-- Update Profile -->
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group text-left">
      <label>Full Name</label>
      <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>

    <div class="form-group text-left">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="form-group text-left">
      <label>Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['mobile_no']) ?>">
    </div>

    <div class="form-group text-left">
      <label>Change Profile Picture</label>
      <input type="file" name="profile_picture" class="form-control-file">
    </div>

    <button type="submit" name="update_profile" class="btn btn-block edit-btn" style="background-color:#69263a; border-color:#69263a; color:#fff;">
      <i class="fas fa-save"></i> Save Changes
    </button>
  </form>

  <hr>

  <!-- Change Password -->
  <form method="POST">
    <h5 class="text-left mb-3">Change Password</h5>

    <div class="form-group text-left">
      <label>Current Password</label>
      <input type="password" name="current_password" class="form-control" required>
    </div>

    <div class="form-group text-left">
      <label>New Password</label>
      <input type="password" name="new_password" class="form-control" required>
    </div>

    <div class="form-group text-left">
      <label>Confirm New Password</label>
      <input type="password" name="confirm_password" class="form-control" required>
    </div>

    <button type="submit" name="change_password" class="btn btn-block edit-btn" style="background-color:#69263a; border-color:#69263a; color:#fff;">
      <i class="fas fa-key"></i> Change Password
    </button>
  </form>
</div>
