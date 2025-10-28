
  <style>
    /* Table header color */
    thead th {
      background-color: #69263a;
      color: #fff;
      text-align: center;
    }

    /* Button custom color */
    .btn-custom {
      background-color: #69263a;
      color: #fff;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #28a745;
      color: #fff;
    }

    .search-input {
      max-width: 300px;
      margin-bottom: 15px;
    }
  </style>

  <div class="container-fluid">
        <h4 class="mb-3"><i class="fas fa-book"></i> Study Material</h4>
        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search by title, type, or category">

        <div class="card">
          <div class="card-body table-responsive">
            <table class="table table-bordered table-hover" id="materialTable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Type</th>
                  <th>Category</th>
                  <th>Uploaded At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- Dynamic rows -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <script>
const materials = [
  { title:"HTML Basics", type:"PDF", category:"Lecture", uploaded:"2025-09-20", url:"#"},
  { title:"CSS Flexbox Video", type:"Video", category:"Lecture", uploaded:"2025-09-21", url:"#"},
  { title:"JS Assignment", type:"DOCX", category:"Assignment", uploaded:"2025-09-22", url:"#"},
  { title:"Bootstrap Guide", type:"PPT", category:"Notes", uploaded:"2025-09-23", url:"#"}
];

function loadMaterials() {
  const tbody = $("#materialTable tbody");
  tbody.empty();
  materials.forEach(m => {
    const row = `
      <tr>
        <td>${m.title}</td>
        <td>${m.type}</td>
        <td>${m.category}</td>
        <td>${m.uploaded}</td>
        <td>
          <a href="${m.url}" class="btn btn-sm btn-custom" target="_blank"><i class="fas fa-eye"></i> View</a>
          <a href="${m.url}" class="btn btn-sm btn-custom" download><i class="fas fa-download"></i> Download</a>
        </td>
      </tr>
    `;
    tbody.append(row);
  });
}

$("#searchInput").on("input", function() {
  const val = $(this).val().toLowerCase();
  $("#materialTable tbody tr").each(function() {
    $(this).toggle($(this).text().toLowerCase().includes(val));
  });
});

$(document).ready(loadMaterials);
</script>