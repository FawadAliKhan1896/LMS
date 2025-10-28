<?php
include('../config/db.php');

// --- ADD ANNOUNCEMENT ---
if (isset($_POST['add_announcement'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = date('Y-m-d');

    $file = null;
    if (!empty($_FILES['file']['name'])) {
        $file = time() . '_' . basename($_FILES['file']['name']);
        $targetPath = "../uploads/announcements/" . $file;
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
    }

    $query = "INSERT INTO announcements (title, description, file, date) VALUES ('$title', '$description', '$file', '$date')";
    mysqli_query($conn, $query);
    header("Location: announcements.php");
    exit();
}

// --- DELETE ANNOUNCEMENT ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM announcements WHERE id = $id");
    header("Location: announcements.php");
    exit();
}

// --- UPDATE ANNOUNCEMENT ---
if (isset($_POST['update_announcement'])) {
    $id = $_POST['announcement_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $fileQuery = "";
    if (!empty($_FILES['file']['name'])) {
        $file = time() . '_' . basename($_FILES['file']['name']);
        $targetPath = "../uploads/announcements/" . $file;
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $fileQuery = ", file = '$file'";
    }

    $query = "UPDATE announcements SET title='$title', description='$description' $fileQuery WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: announcements.php");
    exit();
}
?>

<style>
table thead th {
  background-color: #69263a !important;
  color: #fff;
  text-align: center;
}

.btn-primary, .btn-success, .btn-warning, .btn-danger {
  background-color: #69263a;
  border-color: #69263a;
  transition: all 0.3s ease;
}
.btn-primary:hover, .btn-success:hover, .btn-warning:hover, .btn-danger:hover {
  background-color: #28a745 !important;
  border-color: #28a745 !important;
}
.modal-header {
  background-color: #69263a;
  color: #fff;
}
</style>

<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex align-items-center">
      <h5 class="mb-0"><i class="fas fa-bullhorn"></i> Manage Announcements</h5>
      <button class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#addAnnouncementModal">
        <i class="fas fa-plus"></i> Add Announcement
      </button>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>File</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = mysqli_query($conn, "SELECT * FROM announcements ORDER BY id DESC");
          $count = 1;
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr>
              <td><?= $count++ ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
              <td>
                <?php if ($row['file']) { ?>
                  <a href="../uploads/announcements/<?= $row['file'] ?>" target="_blank"><i class="fas fa-paperclip"></i> View File</a>
                <?php } else { echo '—'; } ?>
              </td>
              <td><?= $row['date'] ?></td>
              <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAnnouncementModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this announcement?');"><i class="fas fa-trash"></i></a>
              </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editAnnouncementModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-white"> 
                  <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Announcement</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="announcement_id" value="<?= $row['id'] ?>">

                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" 
                          value="<?= htmlspecialchars($row['title']) ?>" required>
                      </div>

                      <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" style="text-align: left;">
                          <?= htmlspecialchars($row['description']) ?>
                        </textarea>
                      </div>

                      <div class="form-group">
                        <label>File (optional)</label>
                        <input type="file" name="file" class="form-control">
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" name="update_announcement" class="btn btn-success">Update</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="addAnnouncementModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Announcement</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label>File (optional)</label>
          <input type="file" name="file" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_announcement" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>
