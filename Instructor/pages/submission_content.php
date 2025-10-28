<div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-alt"></i> Student Submissions</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Submitted File</th>
                  <th>Submission Date</th>
                  <th>Total Marks</th>
                  <th>Obtained Marks</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="submissionTable">
                <!-- Example rows -->
                <tr>
                  <td>Ali Ahmed</td>
                  <td><a href="#">assignment1.docx</a></td>
                  <td>2025-09-15 11:30 AM</td>
                  <td class="total-marks">20</td>
                  <td><input type="number" class="form-control form-control-sm obtained-marks" value="15"></td>
                  <td>
                    <button class="btn btn-success btn-sm save-btn"><i class="fas fa-save"></i> Save</button>
                    <button class="btn btn-warning btn-sm edit-btn"><i class="fas fa-edit"></i> Edit</button>
                  </td>
                </tr>
                <tr>
                  <td>Sara Khan</td>
                  <td><a href="#">assignment1.pdf</a></td>
                  <td>2025-09-15 11:40 AM</td>
                  <td class="total-marks">20</td>
                  <td><input type="number" class="form-control form-control-sm obtained-marks" value="18" disabled></td>
                  <td>
                    <button class="btn btn-success btn-sm save-btn" disabled><i class="fas fa-save"></i> Save</button>
                    <button class="btn btn-warning btn-sm edit-btn"><i class="fas fa-edit"></i> Edit</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <script>
  // Save & Edit functionality
  $(document).on("click", ".save-btn", function () {
    let row = $(this).closest("tr");
    let obtained = parseInt(row.find(".obtained-marks").val());
    let total = parseInt(row.find(".total-marks").text());

    if (obtained > total) {
      $("#errorToast").toast("show");
      return; // stop saving
    }

    alert("Marks saved: " + obtained + " / " + total);
    row.find(".obtained-marks").prop("disabled", true);
    $(this).prop("disabled", true);
  });

  $(document).on("click", ".edit-btn", function () {
    let row = $(this).closest("tr");
    row.find(".obtained-marks").prop("disabled", false);
    row.find(".save-btn").prop("disabled", false);
  });
  
</script>