<?php
include('../config/db.php'); // Include DB connection

// ===================== HANDLE DELETE =====================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM results WHERE id=$id");
    echo "<script>
                alert('Result Deleted successfully!');
                window.location.href='questionbank.php';
              </script>";
    exit;
}

// ===================== HANDLE UPDATE =====================
if (isset($_POST['update_result'])) {
    $id = intval($_POST['id'] ?? 0);
    $total_marks = trim($_POST['total_marks'] ?? '');
    $obtained_marks = trim($_POST['obtained_marks'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    if ($id > 0 && $total_marks !== '' && $obtained_marks !== '') {
        $id = mysqli_real_escape_string($conn, $id);
        $total_marks = mysqli_real_escape_string($conn, $total_marks);
        $obtained_marks = mysqli_real_escape_string($conn, $obtained_marks);
        $remarks = mysqli_real_escape_string($conn, $remarks);

        $updateQuery = "UPDATE results SET 
            total_marks='$total_marks', 
            obtained_marks='$obtained_marks', 
            remarks='$remarks' 
            WHERE id='$id'";
        mysqli_query($conn, $updateQuery) or die("Error updating result: " . mysqli_error($conn));

        // Use JS redirect instead of PHP header
        echo "<script>
                alert('Result updated successfully!');
                window.location.href='questionbank.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Please fill all required fields!');</script>";
    }
}


// ===================== FETCH RESULTS =====================
$results = mysqli_query($conn, "
    SELECT results.*, users.name, users.roll_number 
    FROM results 
    LEFT JOIN users ON results.student_id = users.id
    ORDER BY results.id DESC
");

// From here onwards, include sidebar and HTML safely
include('includes/admin_sidebar.php');
?>

<!-- STYLE -->
<style>
body { background: #f4f6f9; }
.content-wrapper { padding: 20px; }
h3 { color: #69263a; font-weight: 600; margin-bottom: 20px; }
.card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.card-header { background: #69263a; color: #fff; font-weight: 500; font-size: 18px; border-bottom: none; }
.custom-table thead { background: #69263a; color: #fff; text-align: center; }
.custom-table th, .custom-table td { vertical-align: middle !important; text-align: center; }
.custom-table tbody tr:hover { background-color: #f9f1f4; transition: background 0.2s ease-in-out; }
.btn-print { background: #69263a; color: #fff; border-radius: 20px; padding: 8px 16px; margin-top: 15px; }
.btn-print:hover { background: #28a745; color: #fff; }
.action-btn { background: #69263a; color: #fff; border: none; border-radius: 5px; padding: 4px 8px; margin: 0 2px; font-size: 13px; cursor: pointer; transition: background 0.3s ease-in-out; }
.action-btn:hover { background: #28a745; color: #fff; }
.modal-lg { max-width: 50%; }
.marks-input { display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 15px; }
.marks-input input { width: 120px; padding: 5px; text-align: center; border-radius: 6px; border: 1px solid #ccc; }
.save-btn { background: #69263a; color: white; padding: 6px 14px; border: none; border-radius: 6px; cursor: pointer; transition: background 0.3s; }
.save-btn:hover { background: #28a745; }
</style>

<!-- RESULTS TABLE -->
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-graduate"></i> Student Result Details
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover custom-table" id="resultTable">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Total Marks</th>
                        <th>Obtained Score</th>
                        <th>Submitted At</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($results)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['roll_number'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($row['total_marks']); ?></td>
                            <td><?= htmlspecialchars($row['obtained_marks']); ?></td>
                            <td><?= htmlspecialchars($row['created_at']); ?></td>
                            <td><?= htmlspecialchars($row['remarks']); ?></td>
                            <td>
                                <button class="action-btn editBtn" 
                                        data-id="<?= $row['id']; ?>"
                                        data-total="<?= $row['total_marks']; ?>"
                                        data-obtained="<?= $row['obtained_marks']; ?>"
                                        data-remarks="<?= htmlspecialchars($row['remarks'], ENT_QUOTES); ?>"
                                        data-toggle="modal" data-target="#editResultModal">
                                    Edit
                                </button>
                                <a href="?delete=<?= $row['id']; ?>" class="action-btn" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button class="btn btn-print" onclick="window.print();"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
</div>

<!-- EDIT RESULT MODAL -->
<div class="modal fade" id="editResultModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Result</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" name="id" id="edit_result_id">
                    <div class="col-md-4 form-group">
                        <label>Total Marks</label>
                        <input type="number" name="total_marks" id="edit_total_marks" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Obtained Marks</label>
                        <input type="number" name="obtained_marks" id="edit_obtained_marks" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Remarks</label>
                        <input type="text" name="remarks" id="edit_remarks" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_result" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- POPULATE MODAL SCRIPT -->
<script>
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit_result_id').value = this.dataset.id;
        document.getElementById('edit_total_marks').value = this.dataset.total;
        document.getElementById('edit_obtained_marks').value = this.dataset.obtained;
        document.getElementById('edit_remarks').value = this.dataset.remarks;
    });
});
</script>
