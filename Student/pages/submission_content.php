  <style>
    /* Table header */
    thead th {
      background-color: #69263a;
      color: #fff;
      text-align: center;
    }

    /* Custom button */
    .btn-custom {
      background-color: #69263a;
      color: #fff;
      border: none;
      transition: 0.3s ease-in-out;
    }

    .btn-custom:hover {
      background-color: #28a745;
      color: #fff;
    }

    #toastContainer {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1055;
    }
  </style>

  <div class="container-fluid">
        <h4 class="mb-3"><i class="fas fa-upload"></i> My Submissions</h4>

        <div class="card">
          <div class="card-header" style="background:#69263a; color:#fff;">
            <h5 class="mb-0"><i class="fas fa-tasks"></i> Assignments / Tasks</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="submissionTable">
              <thead>
                <tr>
                  <th>Task ID</th>
                  <th>Title</th>
                  <th>Course</th>
                  <th>Deadline</th>
                  <th>Time Remaining</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr data-deadline="2025-09-30T23:59:59">
                  <td>TSK-101</td>
                  <td>HTML Assignment</td>
                  <td>Web Development</td>
                  <td>2025-09-30 23:59</td>
                  <td class="timeRemaining"></td>
                  <td class="status">Pending</td>
                  <td class="upload-actions">
                    <input type="file" class="form-control-file uploadInput mb-1">
                    <button class="btn btn-sm btn-custom actionBtn"><i class="fas fa-upload"></i> Upload</button>
                  </td>
                </tr>
                <tr data-deadline="2025-10-05T23:59:59">
                  <td>TSK-102</td>
                  <td>CSS Project</td>
                  <td>Web Development</td>
                  <td>2025-10-05 23:59</td>
                  <td class="timeRemaining"></td>
                  <td class="status">Pending</td>
                  <td class="upload-actions">
                    <input type="file" class="form-control-file uploadInput mb-1">
                    <button class="btn btn-sm btn-custom actionBtn"><i class="fas fa-upload"></i> Upload</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <script>
  // Toast Notification
  function showToast(message, type="success") {
    const toast = $(`
      <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="ml-auto btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    `);
    $("#toastContainer").append(toast);
    new bootstrap.Toast(toast[0], { delay: 2000 }).show();
    toast.on('hidden.bs.toast', function() { $(this).remove(); });
  }

  // Countdown
  function updateCountdowns() {
    $("#submissionTable tbody tr").each(function() {
      const deadline = new Date($(this).data("deadline"));
      const now = new Date();
      let diff = deadline - now;
      let text = "";

      if(diff <= 0) text = "Expired";
      else {
        const days = Math.floor(diff / (1000*60*60*24));
        diff %= (1000*60*60*24);
        const hours = Math.floor(diff / (1000*60*60));
        diff %= (1000*60*60);
        const minutes = Math.floor(diff / (1000*60));
        const seconds = Math.floor((diff % (1000*60)) / 1000);
        text = `${days}d ${hours}h ${minutes}m ${seconds}s`;
      }
      $(this).find(".timeRemaining").text(text);
    });
  }
  setInterval(updateCountdowns, 1000);
  updateCountdowns();

  // File upload & button change
  $(document).on("change", ".uploadInput", function() {
    const row = $(this).closest("tr");
    const btn = row.find(".actionBtn");
    if(this.files.length) {
      btn.html('<i class="fas fa-paper-plane"></i> Submit');
      btn.removeClass("btn-danger").addClass("btn-custom");
    } else {
      btn.html('<i class="fas fa-upload"></i> Upload');
    }
  });

  $(document).on("click", ".actionBtn", function() {
    const row = $(this).closest("tr");
    const fileInput = row.find(".uploadInput")[0];
    const statusCell = row.find(".status");

    if(fileInput.files.length === 0) {
      showToast("Please select a file first!", "danger");
      return;
    }

    statusCell.text("Submitted");
    showToast("File submitted successfully!", "success");
    $(this).prop("disabled", true).text("Submitted ✅");
  });
</script>