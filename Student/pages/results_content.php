  <style>
    /* Table header & buttons theme */
    .table thead th { background-color: #69263a; color: #fff; text-align:center; }
    .table tbody td { text-align:center; vertical-align: middle; }
    .btn-custom {
      background-color: #69263a; color: #fff; border: none; border-radius: 20px; padding: 4px 12px;
      transition: all 0.3s ease-in-out;
    }
    .btn-custom:hover { background-color: #28a745; color: #fff; }
    .search-input { margin-bottom: 15px; }
  </style>

  <div class="container-fluid">
        <h4 class="mb-3"><i class="fas fa-user-graduate"></i> My Results</h4>

        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search by Test ID, Quiz Title, Category">

        <div class="card">
          <div class="card-body table-responsive">
            <table class="table table-bordered table-hover" id="resultsTable">
              <thead>
                <tr>
                  <th>Test ID</th>
                  <th>Title / Activity</th>
                  <th>Category</th>
                  <th>Total Marks</th>
                  <th>Obtained Marks</th>
                  <th>Remarks</th>
                  <th>Submitted At</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

      </div>

      <script>
// Sample dynamic results: add as many activities as needed
const results = [
  {testID:"CT-101", title:"HTML Basics", category:"Class Test", total:20, obtained:18, remarks:"Good", submitted:"2025-09-20 10:30"},
  {testID:"PPT-001", title:"CSS Presentation", category:"PPT", total:10, obtained:9, remarks:"Well Done", submitted:"2025-09-21 11:00"},
  {testID:"ASG-05", title:"JS Assignment", category:"Assignment", total:15, obtained:12, remarks:"Good Work", submitted:"2025-09-22 09:50"},
  {testID:"MT-103", title:"JavaScript Midterm", category:"Midterm", total:40, obtained:36, remarks:"Good Work", submitted:"2025-09-23 12:15"},
  {testID:"FT-110", title:"React Final", category:"Final Term", total:50, obtained:45, remarks:"Excellent", submitted:"2025-09-24 14:20"},
  {testID:"ACT-01", title:"Class Activity 1", category:"Activity", total:5, obtained:5, remarks:"Perfect", submitted:"2025-09-25 09:00"}
];

function loadResults() {
  const tbody = $("#resultsTable tbody");
  tbody.empty();
  results.forEach(r => {
    tbody.append(`
      <tr>
        <td>${r.testID}</td>
        <td>${r.title}</td>
        <td>${r.category}</td>
        <td>${r.total}</td>
        <td>${r.obtained}</td>
        <td>${r.remarks}</td>
        <td>${r.submitted}</td>
      </tr>
    `);
  });
}

// Search functionality
$("#searchInput").on("input", function() {
  const val = $(this).val().toLowerCase();
  $("#resultsTable tbody tr").each(function() {
    $(this).toggle($(this).text().toLowerCase().includes(val));
  });
});

// Load table initially
loadResults();
</script>