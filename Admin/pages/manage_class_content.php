<?php
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    $section = $_POST['section'];
    $instructor_id = $_POST['instructor_id'];

    $query = "INSERT INTO classes (class_name, section, instructor_id) 
              VALUES ('$class_name', '$section', '$instructor_id')";
    mysqli_query($conn, $query);
    echo "<script>
        alert('Course added successfully!');
        window.location.href = 'manage_class.php?msg=added';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class'])) {
    $id = $_POST['edit_id'];
    $class_name = $_POST['class_name'];
    $section = $_POST['section'];
    $instructor_id = $_POST['instructor_id'];

    $query = "UPDATE classes 
              SET class_name='$class_name', section='$section', instructor_id='$instructor_id' 
              WHERE id=$id";
    mysqli_query($conn, $query);
    echo "<script>
        alert('Course Updated successfully!');
        window.location.href = 'manage_class.php';
    </script>";
    exit();
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM classes WHERE id = $id");
    echo "<script>
        alert('Course Deleted successfully!');
        window.location.href = 'manage_class.php';
    </script>";
    exit();
}

$result = mysqli_query($conn, "
    SELECT c.*, u.name AS instructor_name 
    FROM classes c 
    LEFT JOIN users u ON c.instructor_id = u.id
");

$instructors = mysqli_query($conn, "SELECT id, name FROM users WHERE role = 'Instructor'");
?>

<style>
  table thead th {
    background-color: #69263a !important;
    color: #fff !important;
    text-align: center;
  }
  .custom-btn {
    background-color: #69263a !important;
    border-color: #69263a !important;
    color: #fff !important;
    transition: all 0.3s ease;
  }
  .custom-btn:hover {
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
      <h3 class="card-title">Manage Class</h3>
      <div class="card-tools">
        <button class="custom-btn btn-sm" data-toggle="modal" data-target="#addClassModal">
          <i class="fas fa-plus"></i> Add New Class
        </button>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Serial #</th>
            <th>Class Name</th>
            <th>Section</th>
            <th>Instructor</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= $row['class_name']; ?></td>
              <td><?= $row['section']; ?></td>
              <td><?= $row['instructor_name'] ?: 'Not Assigned'; ?></td>
              <td>
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewClass<?= $row['id']; ?>">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editClass<?= $row['id']; ?>">
                  <i class="fas fa-edit"></i>
                </button>
                <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>

            <div class="modal fade" id="viewClass<?= $row['id']; ?>" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">View Class Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <p><strong>Class Name:</strong> <?= $row['class_name']; ?></p>
                    <p><strong>Section:</strong> <?= $row['section']; ?></p>
                    <p><strong>Instructor:</strong> <?= $row['instructor_name'] ?: 'Not Assigned'; ?></p>
                    <p><strong>Created At:</strong> <?= $row['created_at']; ?></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="editClass<?= $row['id']; ?>" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <form method="POST" action="">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Class</h5>
                      <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="edit_id" value="<?= $row['id']; ?>">

                      <div class="form-group">
                        <label>Class Name</label>
                        <input type="text" name="class_name" value="<?= $row['class_name']; ?>" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Section</label>
                        <input type="text" name="section" value="<?= $row['section']; ?>" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Instructor</label>
                        <select name="instructor_id" class="form-control" required>
                          <option value="">Select Instructor</option>
                          <?php
                          $ins_result = mysqli_query($conn, "SELECT id, name FROM users WHERE role='Instructor'");
                          while ($ins = mysqli_fetch_assoc($ins_result)) {
                            $selected = $ins['id'] == $row['instructor_id'] ? 'selected' : '';
                            echo "<option value='{$ins['id']}' $selected>{$ins['name']}</option>";
                          }
                          ?>
                        </select>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="edit_class" class="btn btn-success">Update Class</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="addClassModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="POST" action="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Class</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Class Name</label>
            <input type="text" name="class_name" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Section</label>
            <input type="text" name="section" class="form-control">
          </div>

          <div class="form-group">
            <label>Instructor</label>
            <select name="instructor_id" class="form-control" required>
              <option value="">Select Instructor</option>
              <?php
              $ins = mysqli_query($conn, "SELECT id, name FROM users WHERE role='Instructor'");
              while ($row = mysqli_fetch_assoc($ins)) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
              ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="add_class" class="btn btn-success">Add Class</button>
        </div>
      </div>
    </form>
  </div>
</div>
