<?php
include('../config/db.php');

// ===================== DELETE RESULT =====================
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM results WHERE id=$id");
    echo "<script>window.location.href='manage_result.php';</script>";
    exit;
}

// ===================== UPDATE RESULT =====================
if(isset($_POST['result_id'])){
    $id = intval($_POST['result_id']);
    $total_marks = intval($_POST['total_marks']);
    $obtained_marks = intval($_POST['obtained_marks']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

    mysqli_query($conn, "UPDATE results SET total_marks=$total_marks, obtained_marks=$obtained_marks, remarks='$remarks' WHERE id=$id");
    echo "<script>window.location.href='manage_result.php';</script>";
    exit;
}

// ===================== FETCH QUIZZES WITH RESULTS =====================
$quizzes = mysqli_query($conn, "
    SELECT q.*, r.id as result_id, r.total_marks, r.obtained_marks, r.remarks, r.created_at as result_created
    FROM quizzes q
    LEFT JOIN results r ON r.quiz_id = q.id
    ORDER BY q.id DESC
");

$grouped = ['Class Test'=>[], 'Mid Term'=>[], 'Final Term'=>[]];
while($row = mysqli_fetch_assoc($quizzes)){
    $title = $row['quiz_title'];
    if(stripos($title,'Class Test') !== false) {
        $grouped['Class Test'][] = $row;
    } else if(stripos($title,'Mid Term') !== false || stripos($title,'Midterm') !== false) {
        $grouped['Mid Term'][] = $row;
    } else {
        $grouped['Final Term'][] = $row;
    }
}
?>

<!-- Bootstrap 4 CSS & JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
.custom-table { border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; }
.custom-table thead { background: #69263a; color: #fff; text-align: center; }
.custom-table th, .custom-table td { text-align: center; vertical-align: middle !important; }
.custom-table tbody tr:hover { background-color: #f9f1f4; transition: background 0.2s ease-in-out; }
.custom-btn { border-radius: 20px; padding: 4px 12px; font-size: 13px; background: #69263a; border: none; color: #fff; transition: all 0.3s ease-in-out; }
.custom-btn:hover { background: green !important; }
.modal-header { background: #69263a; color: #fff; }
</style>

<div class="content-wrapper p-3" style="margin-left: 0px !important">
    <h4 class="mb-3"><i class="fas fa-user-graduate"></i> Student Results</h4>

    <!-- Filters -->
    <div class="row mb-2">
        <div class="col-md-3">
            <select id="classFilter" class="form-control">
                <option value="all">All Categories</option>
                <option value="Class Test">Class Test</option>
                <option value="Mid Term">Mid Term</option>
                <option value="Final Term">Final Term</option>
            </select>
        </div>
        <div class="col-md-5">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Quiz Title or Test ID">
        </div>
        <!-- <div class="col-md-2">
            <button id="searchBtn" class="btn custom-btn"><i class="fas fa-search"></i> Search</button>
        </div> -->
        <div class="col-md-2 text-right">
            <button onclick="window.print()" class="btn custom-btn"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="resultTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#classtest" role="tab">Class Test</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#midterm" role="tab">Midterm</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#finalterm" role="tab">Final Term</a></li>
    </ul>

    <!-- Tables -->
    <div class="tab-content mt-2">
        <?php foreach($grouped as $cat=>$quizzesArr):
            $tabId = strtolower(str_replace(' ','',$cat)); ?>
            <div class="tab-pane fade <?php if($cat=='Class Test') echo 'show active'; ?>" id="<?= $tabId ?>" role="tabpanel">
                <table class="table table-bordered table-hover custom-table">
                    <thead>
                        <tr>
                            <th>Test ID</th>
                            <th>Quiz Title</th>
                            <th>Total Marks</th>
                            <th>Obtained Marks</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($quizzesArr as $q): ?>
                        <tr data-category="<?= htmlspecialchars($cat) ?>" data-result-id="<?= $q['result_id'] ?? '' ?>" data-marks="<?= $q['marks'] ?>" data-obtained="<?= $q['obtained_marks'] ?? '' ?>" data-remarks="<?= htmlspecialchars($q['remarks'] ?? '') ?>">
                            <td><?= htmlspecialchars($q['id']) ?></td>
                            <td><?= htmlspecialchars($q['quiz_title']) ?></td>
                            <td><?= htmlspecialchars($q['marks']) ?></td>
                            <td><?= htmlspecialchars($q['obtained_marks'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($q['result_created'] ?? '-') ?></td>
                            <td>
                                <button class="btn btn-sm custom-btn edit-result">Edit</button>
                                <a href="?delete=<?= $q['result_id'] ?? $q['id'] ?>" class="btn btn-sm custom-btn" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Edit Result Modal -->
<div class="modal fade" id="editResultModal" tabindex="-1" role="dialog" aria-labelledby="editResultModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="POST" id="editResultForm">
      <div class="modal-content" style="width: 600px">
        <div class="modal-header">
          <h5 class="modal-title" id="editResultModalLabel">Edit Result</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="result_id" id="edit_result_id">

            <div class="form-group">
                <label>Quiz Title</label>
                <input type="text" class="form-control" id="edit_quiz_title" readonly>
            </div>

            <div class="form-group">
                <label>Total Marks</label>
                <input type="number" class="form-control" name="total_marks" id="edit_total_marks" required>
            </div>

            <div class="form-group">
                <label>Obtained Marks</label>
                <input type="number" class="form-control" name="obtained_marks" id="edit_obtained_marks" required>
            </div>

            <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remarks" id="edit_remarks" rows="2"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn custom-btn">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function(){

    // ===================== Filters/Search =====================
    function filterTables() {
        const searchValRaw = $("#searchInput").val();
        const searchVal = String(searchValRaw || '').toLowerCase().trim();
        const selectedCategory = $("#classFilter").val();

        let anyMatch = false;

        $(".tab-pane").each(function(){
            const $pane = $(this);
            const $table = $pane.find("table");
            let tableHasMatch = false;

            $table.find("tbody tr").each(function(){
                const $tr = $(this);
                const testId = String($tr.find("td").eq(0).text() || '').toLowerCase().trim();
                const quizTitle = String($tr.find("td").eq(1).text() || '').toLowerCase().trim();
                const rowCategory = String($tr.data("category") || '').toLowerCase().trim();

                const matchesSearch = (searchVal === '') || (testId.indexOf(searchVal) !== -1) || (quizTitle.indexOf(searchVal) !== -1);
                const matchesCategory = (selectedCategory === "all") || (rowCategory === selectedCategory.toLowerCase());

                const shouldShow = matchesSearch && matchesCategory;

                $tr.toggle(shouldShow);
                if (shouldShow) { tableHasMatch = true; anyMatch = true; }
            });

            if (!tableHasMatch) {
                if ($pane.find(".no-results").length === 0) {
                    $table.after('<div class="no-results p-3 text-center text-muted">No results found.</div>');
                }
            } else { $pane.find(".no-results").remove(); }

            $pane.data('hasMatch', tableHasMatch);
        });

        if (selectedCategory !== "all") {
            const tabId = selectedCategory.toLowerCase().replace(/\s+/g,'');
            const $tabLink = $("#resultTabs a[href='#" + tabId + "']");
            if ($tabLink.length) $tabLink.tab('show');
        } else if (anyMatch) {
            const $firstPaneWithMatch = $(".tab-pane").filter(function(){ return $(this).data('hasMatch') === true; }).first();
            if ($firstPaneWithMatch.length) $("#resultTabs a[href='#" + $firstPaneWithMatch.attr('id') + "']").tab('show');
        } else { $("#resultTabs a[href='#classtest']").tab('show'); }
    }

    $("#searchInput").on("input", filterTables);
    $("#searchInput").on("keypress", function(e){ if(e.which === 13){ e.preventDefault(); filterTables(); } });
    $("#classFilter").on("change", filterTables);
    $("#searchBtn").on("click", filterTables);
    $('a[data-toggle="tab"]').on('shown.bs.tab', filterTables);
    filterTables();

    // ===================== Edit Modal =====================
    $(document).on('click', '.edit-result', function(){
        const $row = $(this).closest('tr');
        const resultId = $row.data('result-id');
        if(!resultId) { alert('Result not yet created.'); return; }

        $('#edit_result_id').val(resultId);
        $('#edit_quiz_title').val($row.find('td').eq(1).text().trim());
        $('#edit_total_marks').val($row.data('marks'));
        $('#edit_obtained_marks').val($row.data('obtained'));
        $('#edit_remarks').val($row.data('remarks'));

        $('#editResultModal').modal('show');
    });

});
</script>
