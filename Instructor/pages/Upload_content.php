<div class="container-fluid">

        <!-- Upload Form -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-upload"></i> Upload Material</h3>
          </div>
          <form id="materialForm">
            <div class="card-body">
              <div class="form-group">
                <label>Material Title</label>
                <input type="text" class="form-control" id="materialTitle" placeholder="Enter material title" required>
              </div>
              <div class="form-group">
                <label>Select File</label>
                <input type="file" class="form-control" id="materialFile" accept=".pdf,.doc, .docx, .xls, .xlsx, .csv, .ppt, .pptx, .ppsx, .mp4,.jpg, .jpeg, .png, .gif, .zip, .rar">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="materialDesc" rows="2" placeholder="Enter short description"></textarea>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Material</button>
              <button type="button" id="updateBtn" class="btn btn-success d-none"><i class="fas fa-save"></i> Update Material</button>
              <button type="button" id="cancelBtn" class="btn btn-secondary d-none">Cancel</button>
            </div>
          </form>
        </div>

        <!-- Material List -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Uploaded Materials</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered" id="materialTable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>File</th>
                  <th>Description</th>
                  <th>Upload Date</th>
                  <th>Modified Date</th>
                  <th style="width:120px">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr><td colspan="6" class="text-center">No material uploaded yet.</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <script>
  let materials = [];
  let editIndex = -1;

  function renderTable() {
    let tbody = $("#materialTable tbody");
    tbody.empty();
    if (materials.length === 0) {
      tbody.append(`<tr><td colspan="6" class="text-center">No material uploaded yet.</td></tr>`);
      return;
    }
    materials.forEach((m, i) => {
      tbody.append(`
        <tr>
          <td>${m.title}</td>
          <td>${m.file ? `<i class="fas fa-file"></i> ${m.file}` : "-"}</td>
          <td>${m.desc || "-"}</td>
          <td>${m.uploadDate}</td>
          <td>${m.modifiedDate || "-"}</td>
          <td>
            <button class="btn btn-sm btn-info" onclick="editMaterial(${i})"><i class="fas fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="deleteMaterial(${i})"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
      `);
    });
  }

  $("#materialForm").on("submit", function(e){
    e.preventDefault();
    let title = $("#materialTitle").val();
    let file = $("#materialFile")[0].files[0];
    let desc = $("#materialDesc").val();
    let fileName = file ? file.name : "";
    let today = new Date().toLocaleString();

    materials.push({
      title, 
      file: fileName, 
      desc, 
      uploadDate: today, 
      modifiedDate: null
    });

    renderTable();
    this.reset();
  });

  function editMaterial(index) {
    let m = materials[index];
    $("#materialTitle").val(m.title);
    $("#materialDesc").val(m.desc);
    editIndex = index;

    $("#updateBtn, #cancelBtn").removeClass("d-none");
    $("#materialForm button[type='submit']").addClass("d-none");
  }

  $("#updateBtn").on("click", function(){
    let title = $("#materialTitle").val();
    let desc = $("#materialDesc").val();
    let file = $("#materialFile")[0].files[0];
    let fileName = file ? file.name : materials[editIndex].file;
    let modifiedDate = new Date().toLocaleString();

    materials[editIndex] = {
      ...materials[editIndex],
      title, 
      desc, 
      file: fileName, 
      modifiedDate
    };

    renderTable();
    resetForm();
  });

  $("#cancelBtn").on("click", function(){
    resetForm();
  });

  function deleteMaterial(index) {
    materials.splice(index, 1);
    renderTable();
  }

  function resetForm(){
    $("#materialForm")[0].reset();
    editIndex = -1;
    $("#updateBtn, #cancelBtn").addClass("d-none");
    $("#materialForm button[type='submit']").removeClass("d-none");
  }

  renderTable();
</script>