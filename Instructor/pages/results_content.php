<style>
    #toastContainer { position: fixed; top: 20px; right: 20px; z-index: 1050; }
    .toast { min-width: 250px; margin-bottom: 10px; }

    .custom-table { border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .custom-table thead { background: #69263a; color: #fff; text-align: center; }
    .custom-table th, .custom-table td { text-align: center; vertical-align: middle !important; }
    .custom-table tbody tr:hover { background-color: #f9f1f4; transition: background 0.2s ease-in-out; }

    .custom-btn { border-radius: 20px; padding: 4px 12px; font-size: 13px; background: #69263a; border: none; color: #fff; transition: all 0.3s ease-in-out; }
    .custom-btn:hover { background: green !important; }

    .modal-header { background: #69263a; color: #fff; }
  </style>

<!-- Content -->
  <div class="content-wrapper p-3" style="margin-left: 0 !important">
    <h4 class="mb-3"><i class="fas fa-user-graduate"></i> Student Results</h4>

        <!-- Filters -->
    <div class="row mb-2">
      <div class="col-md-4">
        <select id="classFilter" class="form-control"></select>
        
      </div>
      <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Quiz Title or Test ID">
      </div>
      <div class="col-md-4 text-right">
        <button onclick="window.print()" class="btn custom-btn"><i class="fas fa-print"></i> Print</button>
      </div>
    </div>


    <!-- Tabs -->
    <ul class="nav nav-tabs" id="resultTabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" id="classTest-tab" data-toggle="tab" href="#classTest" role="tab">Class Test</a></li>
      <li class="nav-item"><a class="nav-link" id="midterm-tab" data-toggle="tab" href="#midterm" role="tab">Midterm</a></li>
      <li class="nav-item"><a class="nav-link" id="finalterm-tab" data-toggle="tab" href="#finalterm" role="tab">Final Term</a></li>
    </ul>

    <!-- Tables -->
    <div class="tab-content mt-2">
      <div class="tab-pane fade show active" id="classTest" role="tabpanel">
        <table class="table table-bordered table-hover custom-table" id="classTestTable">
          <thead>
            <tr>
              <th>Test ID</th>
              <th>Quiz Title</th>
              <th>Total Marks</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="midterm" role="tabpanel">
        <table class="table table-bordered table-hover custom-table" id="midtermTable">
          <thead>
            <tr>
              <th>Test ID</th>
              <th>Quiz Title</th>
              <th>Total Marks</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="finalterm" role="tabpanel">
        <table class="table table-bordered table-hover custom-table" id="finalTermTable">
          <thead>
            <tr>
              <th>Test ID</th>
              <th>Quiz Title</th>
              <th>Total Marks</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>


  <!-- Toast -->
<div id="toastContainer"></div>


<script>
  function showToast(msg, type="success"){
    const t = $(`<div class="toast text-white bg-${type}"><div class="toast-body">${msg}</div></div>`);
    $("#toastContainer").append(t);
    $(t).toast({delay:2000}); $(t).toast("show");
    t.on("hidden.bs.toast",()=>$(t).remove());
  }

  let results = [
    {id:"CT-101", quiz:"HTML Basics", category:"Class Test", total:20, created:"2025-09-20"},
    {id:"MT-201", quiz:"JS Midterm", category:"Midterm", total:40, created:"2025-09-21"},
    {id:"FT-301", quiz:"React Final", category:"Final Term", total:50, created:"2025-09-22"},
    {id:"CT-102", quiz:"CSS Basics", category:"Class Test", total:25, created:"2025-09-20"}
  ];

  const categories = ["Class Test","Midterm","Final Term"];

  function loadResults(){
    $("#classTestTable tbody, #midtermTable tbody, #finalTermTable tbody").empty();
    results.forEach(r=>{
      const row = `<tr>
        <td>${r.id}</td>
        <td>${r.quiz}</td>
        <td>${r.total}</td>
        <td>${r.created}</td>
        <td><button class="btn btn-sm custom-btn viewBtn" onclick="window.location.href='view.html'"><i class="fas fa-eye"></i> View</button></td>
      </tr>`;
      if(r.category==="Class Test") $("#classTestTable tbody").append(row);
      if(r.category==="Midterm") $("#midtermTable tbody").append(row);
      if(r.category==="Final Term") $("#finalTermTable tbody").append(row);
    });
  }

  $(document).ready(function(){
    loadResults();

    // Search
    $("#searchInput").on("input", function(){
      const val = $(this).val().toLowerCase();
      $("table tbody tr").each(function(){
        $(this).toggle($(this).text().toLowerCase().includes(val));
      });
    });
  });
</script>