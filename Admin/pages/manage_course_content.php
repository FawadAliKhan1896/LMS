<?php
include('../config/db.php'); 

if (isset($_POST['add_course'])) {
    $title = mysqli_real_escape_string($conn, $_POST['course_title']);
    $code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $session = mysqli_real_escape_string($conn, $_POST['session']);

    $query = "INSERT INTO courses (course_title, course_code, batch, semester, session) 
              VALUES ('$title', '$code', '$batch', '$semester', '$session')";
    mysqli_query($conn, $query);
    header("Location: manage_course.php?msg=added");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM courses WHERE id = $id");
    header("Location: manage_course.php?msg=deleted");
    exit;
}

if (isset($_POST['update_course'])) {
    $id = intval($_POST['course_id']);
    $title = mysqli_real_escape_string($conn, $_POST['course_title']);
    $code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $session = mysqli_real_escape_string($conn, $_POST['session']);

    $query = "UPDATE courses SET 
              course_title='$title',
              course_code='$code',
              batch='$batch',
              semester='$semester',
              session='$session'
              WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: manage_course.php?msg=updated");
    exit;
}

$courses = mysqli_query($conn, "SELECT * FROM courses ORDER BY id DESC");
?>

<style>
table thead th { background-color: #69263a !important; color: #fff !important; text-align: center; }
.card-tools .btn { background-color: #69263a !important; border-color: #69263a !important; color: #fff !important; transition: all 0.3s; }
.card-tools .btn:hover { background-color: #28a745 !important; }
.btn-info, .btn-warning, .btn-danger { background-color: #69263a !important; border-color: #69263a !important; color: #fff !important; transition: all 0.3s; }
.btn-info:hover, .btn-warning:hover, .btn-danger:hover { background-color: #28a745 !important; }
.modal-header { background-color: #69263a !important; color: #fff !important; }
.modal-footer .btn-success { background-color: #69263a !important; border-color: #69263a !important; color: #fff !important; transition: all 0.3s; }
.modal-footer .btn-success:hover { background-color: #28a745 !important; }
.btn-close-white { filter: invert(1); }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Course</h3>
            <div class="card-tools">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCourseModal">
                    <i class="fas fa-plus"></i> Add New Course
                </button>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Serial #</th>
                        <th>Course Title</th>
                        <th>Course Code</th>
                        <th>Batch</th>
                        <th>Semester</th>
                        <th>Session</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $serial = 1;
                    while ($row = mysqli_fetch_assoc($courses)): ?>
                    <tr>
                        <td><?= $serial++ ?></td>
                        <td><?= htmlspecialchars($row['course_title']) ?></td>
                        <td><?= htmlspecialchars($row['course_code']) ?></td>
                        <td><?= htmlspecialchars($row['batch']) ?></td>
                        <td><?= htmlspecialchars($row['semester']) ?></td>
                        <td><?= htmlspecialchars($row['session']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Course</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="course_id" value="<?= $row['id'] ?>">
                                        <div class="form-group">
                                            <label>Course Title</label>
                                            <input type="text" name="course_title" class="form-control" value="<?= htmlspecialchars($row['course_title']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Course Code</label>
                                            <input type="text" name="course_code" class="form-control" value="<?= htmlspecialchars($row['course_code']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Batch</label>
                                            <input type="text" name="batch" class="form-control" value="<?= htmlspecialchars($row['batch']) ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Semester</label>
                                            <input type="text" name="semester" class="form-control" value="<?= htmlspecialchars($row['semester']) ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Session</label>
                                            <input type="text" name="session" class="form-control" value="<?= htmlspecialchars($row['session']) ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update_course" class="btn btn-success">Update Course</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Course</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Course Title</label>
                        <input type="text" name="course_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Course Code</label>
                        <input type="text" name="course_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Batch</label>
                        <input type="text" name="batch" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" name="semester" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Session</label>
                        <input type="text" name="session" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_course" class="btn btn-success">Add Course</button>
                </div>
            </div>
        </form>
    </div>
</div>
