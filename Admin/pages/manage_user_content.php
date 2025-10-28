<?php
include('../config/db.php');

// ===================== ADD USER =====================
if (isset($_POST['add_user'])) {
  $name = $_POST['name'];
  $father_name = $_POST['father_name'];
  $mobile_no = $_POST['mobile_no'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $gender = $_POST['gender'];
  $role = $_POST['role'];
  $class_id = $_POST['class_id'] ?: NULL;
  $roll_number = $_POST['roll_number'] ?: NULL;

  // Handle profile picture
  $profile_picture = '';
  if (!empty($_FILES['profile_picture']['name'])) {
    $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
    $target = "../uploads/" . $fileName;
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
      $profile_picture = $fileName;
    }
  }

  mysqli_query($conn, "INSERT INTO users 
  (name, father_name, mobile_no, email, password, gender, role, class_id, roll_number, profile_picture) 
  VALUES 
  ('$name','$father_name','$mobile_no','$email','$password','$gender','$role','$class_id','$roll_number','$profile_picture')");
}

// ===================== DELETE USER =====================
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM users WHERE id=$id");
}

// ===================== EDIT USER =====================
if (isset($_POST['update_user'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $father_name = $_POST['father_name'];
  $mobile_no = $_POST['mobile_no'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $role = $_POST['role'];
  $class_id = $_POST['class_id'] ?: NULL;
  $roll_number = $_POST['roll_number'] ?: NULL;

  $query = "UPDATE users SET 
    name='$name',
    father_name='$father_name',
    mobile_no='$mobile_no',
    email='$email',
    gender='$gender',
    role='$role',
    class_id='$class_id',
    roll_number='$roll_number'
    WHERE id=$id";
    
  mysqli_query($conn, $query);
}

// ===================== FETCH USERS =====================
$users = mysqli_query($conn, "SELECT users.*, classes.class_name FROM users LEFT JOIN classes ON users.class_id = classes.id ORDER BY users.id DESC");
?>

<style>
  table thead th {
    background-color: #69263a !important;
    color: #fff !important;
    text-align: center;
  }

  .card-tools .btn,
  .btn-info,
  .btn-warning,
  .btn-danger {
    background-color: #69263a !important;
    border-color: #69263a !important;
    color: #fff !important;
    transition: all 0.3s ease-in-out;
  }

  .btn:hover {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
  }

  .modal-header {
    background-color: #69263a !important;
    color: #fff !important;
  }
</style>

<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Manage Users</h3>
      <div class="card-tools">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
          <i class="fas fa-plus"></i> Add New User
        </button>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Father Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Password</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Class</th>
            <th>Roll Number</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($users)) {
          ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= htmlspecialchars($row['name']); ?></td>
              <td><?= htmlspecialchars($row['father_name']); ?></td>
              <td><?= htmlspecialchars($row['mobile_no']); ?></td>
              <td><?= htmlspecialchars($row['email']); ?></td>
              <td><?= htmlspecialchars($row['password']); ?></td>
              <td><?= htmlspecialchars($row['gender']); ?></td>
              <td><?= htmlspecialchars($row['role']); ?></td>
              <td><?= htmlspecialchars($row['class_name'] ?? 'N/A'); ?></td>
              <td><?= htmlspecialchars($row['roll_number'] ?? 'N/A'); ?></td>
              <td>
                <button class="btn btn-warning btn-sm editBtn" 
                  data-id="<?= $row['id']; ?>"
                  data-name="<?= $row['name']; ?>"
                  data-father="<?= $row['father_name']; ?>"
                  data-mobile="<?= $row['mobile_no']; ?>"
                  data-email="<?= $row['email']; ?>"
                  data-gender="<?= $row['gender']; ?>"
                  data-role="<?= $row['role']; ?>"
                  data-class="<?= $row['class_id']; ?>"
                  data-roll="<?= $row['roll_number']; ?>">
                  <i class="fas fa-edit"></i>
                </button>
                <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body row">
          <div class="col-md-6 form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Father Name</label>
            <input type="text" name="father_name" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label>Mobile No</label>
            <input type="text" name="mobile_no" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Gender</label>
            <select name="gender" class="form-control">
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>Role</label>
            <select name="role" id="add_role" class="form-control">
              <option>Admin</option>
              <option>Instructor</option>
              <option>Student</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>Class</label>
            <select name="class_id" class="form-control">
              <option value="">None</option>
              <?php
              $classes = mysqli_query($conn, "SELECT id,class_name FROM classes");
              while ($c = mysqli_fetch_assoc($classes)) {
                echo "<option value='{$c['id']}'>{$c['class_name']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-6 form-group" id="rollNumberDiv" style="display:none;">
            <label>Roll Number</label>
            <input type="text" name="roll_number" class="form-control">
          </div>
          <div class="col-md-12 form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_user" class="btn btn-success">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editUserModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body row">
          <input type="hidden" name="id" id="edit_id">
          <div class="col-md-6 form-group">
            <label>Name</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Father Name</label>
            <input type="text" name="father_name" id="edit_father" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label>Mobile No</label>
            <input type="text" name="mobile_no" id="edit_mobile" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" name="email" id="edit_email" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Gender</label>
            <select name="gender" id="edit_gender" class="form-control">
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>Role</label>
            <select name="role" id="edit_role" class="form-control">
              <option>Admin</option>
              <option>Instructor</option>
              <option>Student</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>Class</label>
            <select name="class_id" id="edit_class" class="form-control">
              <option value="">None</option>
              <?php
              $classRes = mysqli_query($conn, "SELECT id,class_name FROM classes");
              while ($cls = mysqli_fetch_assoc($classRes)) {
                echo "<option value='{$cls['id']}'>{$cls['class_name']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-6 form-group" id="editRollNumberDiv" style="display:none;">
            <label>Roll Number</label>
            <input type="text" name="roll_number" id="edit_roll_number" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_user" class="btn btn-success">Update User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Toggle Roll Number field in Add Modal
  document.getElementById('add_role').addEventListener('change', function() {
    document.getElementById('rollNumberDiv').style.display = this.value === 'Student' ? 'block' : 'none';
  });

  // Toggle Roll Number field in Edit Modal
  document.getElementById('edit_role').addEventListener('change', function() {
    document.getElementById('editRollNumberDiv').style.display = this.value === 'Student' ? 'block' : 'none';
  });

  // Populate Edit Modal
  document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('edit_id').value = btn.dataset.id;
      document.getElementById('edit_name').value = btn.dataset.name;
      document.getElementById('edit_father').value = btn.dataset.father;
      document.getElementById('edit_mobile').value = btn.dataset.mobile;
      document.getElementById('edit_email').value = btn.dataset.email;
      document.getElementById('edit_gender').value = btn.dataset.gender;
      document.getElementById('edit_role').value = btn.dataset.role;
      document.getElementById('edit_class').value = btn.dataset.class;
      document.getElementById('edit_roll_number').value = btn.dataset.roll || '';
      document.getElementById('editRollNumberDiv').style.display = btn.dataset.role === 'Student' ? 'block' : 'none';
      $('#editUserModal').modal('show');
    });
  });
</script>
