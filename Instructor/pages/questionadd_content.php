<style>
  /* Table header styling */
  table thead th {
    background-color: #69263a !important;
    color: #fff !important;
    text-align: center;
  }

  /* Buttons styling */
  .btn, .btn-primary, .btn-success, .btn-warning, .btn-info, .btn-danger {
    background-color: #69263a !important;
    border-color: #69263a !important;
    color: #fff !important;
  }
  .btn:hover, .btn-primary:hover, .btn-success:hover, .btn-warning:hover, .btn-info:hover, .btn-danger:hover {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: #fff !important;
  }

  /* Card headers styling */
  .card-header {
    background-color: #69263a !important;
    color: #fff !important;
  }
</style>


<div class="container-fluid">

        <!-- Quiz Info & Add Question Card -->
        <div class="card mb-3">
          <div class="card-header bg-primary text-white" style="background-color: #69263a;">
            <h5 class="mb-0"><i class="fas fa-file-signature"></i> Quiz Information & Add Question</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Left: Quiz Information -->
              <div class="col-md-6">
                <h6 class="text-primary"><i class="fas fa-info-circle"></i> Quiz Information</h6>
                <form id="quizInfoForm">
                  <div class="form-group">
                    <label for="quizTitle">Quiz Title</label>
                    <input type="text" class="form-control" id="quizTitle" placeholder="Enter quiz title" required>
                  </div>
                  <div class="form-group">
                    <label for="totalQuestions">Total Questions</label>
                    <input type="number" class="form-control" id="totalQuestions" placeholder="e.g. 10" required>
                  </div>
                  <div class="form-group">
                    <label for="quizDuration">Duration (minutes)</label>
                    <input type="number" class="form-control" id="quizDuration" placeholder="e.g. 30" required>
                  </div>
                </form>
              </div>

              <!-- Right: Add Question -->
              <div class="col-md-6">
                <h6 class="text-success"><i class="fas fa-plus-circle"></i> Add Question</h6>
                <form id="questionForm">
                  <div class="form-group">
                    <label for="questionType">Question Type</label>
                    <select id="questionType" class="form-control">
                      <option value="mcq">Objective (MCQ / True-False)</option>
                      <option value="blank">Fill in the Blanks</option>
                      <option value="subjective">Subjective</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="marks">Marks</label>
                    <input type="number" class="form-control" id="marks" required>
                  </div>
                  <div class="form-group">
                    <label for="questionText">Question</label>
                    <textarea id="questionText" class="form-control" rows="2" required></textarea>
                  </div>

                  <!-- MCQ Options -->
                  <div id="mcqOptions" style="display:none;">
                    <label>Options</label>
                    <input type="text" class="form-control mb-2" placeholder="Option A">
                    <input type="text" class="form-control mb-2" placeholder="Option B">
                    <input type="text" class="form-control mb-2" placeholder="Option C">
                    <input type="text" class="form-control mb-2" placeholder="Option D">
                    <select class="form-control mt-2">
                      <option value="">Select Correct Answer</option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                    </select>
                  </div>

                  <!-- Negative Marking -->
                  <div class="form-group mt-3">
                    <label>Negative Marking</label><br>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="negativeToggle">
                      <label class="custom-control-label" for="negativeToggle">Enable</label>
                    </div>
                    <input type="number" class="form-control mt-2" id="negativeMarks" placeholder="e.g. -1" style="display:none;">
                  </div>

                  <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Add Question</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Questions Table -->
        <div class="card">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Questions List</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered" id="questionsTable">
              <thead>
                <tr>
                  <th>Quiz Title</th>
                  <th>Marks</th>
                  <th>Question</th>
                  <th>Type</th>
                  <th>Negative</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- Toast container -->
<div id="toastContainer"></div>

      <script>
        function showToast(message, type="success") {
            const toast = $(`
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="ml-auto btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            `);
            $("#toastContainer").append(toast);
            const bsToast = new bootstrap.Toast(toast[0], { delay: 2000 });
            bsToast.show();
            toast.on('hidden.bs.toast', function() { $(this).remove(); });
        }

        // Show/Hide MCQ Options
        $("#questionType").on("change", function() {
            $("#mcqOptions").toggle($(this).val() === "mcq");
        });

        // Negative marking toggle
        $("#negativeToggle").on("change", function() {
            $("#negativeMarks").toggle($(this).is(":checked")).val('');
        });

        // Add Question
        $("#questionForm").on("submit", function(e) {
            e.preventDefault();
            const quizTitle = $("#quizTitle").val();
            const type = $("#questionType").val();
            const marks = $("#marks").val();
            const question = $("#questionText").val();
            const negative = $("#negativeToggle").is(":checked") ? $("#negativeMarks").val() : "0";

            const row = `
            <tr>
                <td>${quizTitle}</td>
                <td>${marks}</td>
                <td>${question}</td>
                <td>${type}</td>
                <td>${negative}</td>
                <td>
                <button class="btn btn-sm btn-warning editBtn"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger deleteBtn"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
            $("#questionsTable tbody").append(row);

            $("#questionForm")[0].reset();
            $("#mcqOptions").hide();
            $("#negativeMarks").hide();

            showToast("Question added successfully", "success");
        });

        // Delete Question
        $(document).on("click", ".deleteBtn", function() {
            $(this).closest("tr").remove();
            showToast("Question deleted", "danger");
        });

        // Edit Question
        $(document).on("click", ".editBtn", function() {
            const row = $(this).closest("tr");
            $("#marks").val(row.find("td:eq(1)").text());
            $("#questionText").val(row.find("td:eq(2)").text());
            $("#questionType").val(row.find("td:eq(3)").text()).trigger("change");
            $("#negativeMarks").val(row.find("td:eq(4)").text());
            row.remove();
            showToast("Edit the question and re-add", "info");
        });
    </script>