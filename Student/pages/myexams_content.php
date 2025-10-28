<style>
    .attempt-btn { background: #69263a; color: #fff; }
    .attempt-btn:hover { background: #218838; }
    button:disabled { background: gray !important; cursor: not-allowed; }
  </style>

  <div class="container-fluid">
        <div class="card">
      <div class="card-header text-white" style="background-color: #69263a;">
      <h3 class="card-title"><i class="fas fa-file-alt"></i> Available Exams</h3>
      </div>
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Test ID</th>
                  <th>Exam Title</th>
                  <th>Total Questions</th>
                  <th>Timeslot</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="examTableBody"></tbody>
            </table>
            <div id="message" class="mt-3"></div>
          </div>
        </div>
      </div>

      <script>
const exams = [
  {id: "WD-101", title: "Class Test 1", total: 25, duration: "40 minutes"},
  {id: "WD-102", title: "Class Test 2", total: 25, duration: "40 minutes"},
  {id: "wD-103", title: "Class Test 3", total: 25, duration: "40 minutes"},
  {id: "WD-105", title: "Mid Term", total: 15, duration: "40 minutes"},
  // more exams can go here
];

// Get attempted exams from localStorage
let attemptedExams = JSON.parse(localStorage.getItem('attemptedExams') || "[]");

function loadExams() {
  const tbody = document.getElementById("examTableBody");
  tbody.innerHTML = "";

  exams.forEach(exam => {
    const isAttempted = attemptedExams.includes(exam.id);
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${exam.id}</td>
      <td>${exam.title}</td>
      <td>${exam.total}</td>
      <td>${exam.duration}</td>
      <td id="status-${exam.id}" class="${isAttempted ? 'text-danger' : 'text-success'}">
        ${isAttempted ? 'Attempted' : 'Not Attempted'}
      </td>
      <td>
        <button 
          class="btn attempt-btn btn-sm"
          id="btn-${exam.id}"
          ${isAttempted ? 'disabled' : ''}
          onclick="attemptExam('${exam.id}','${exam.title}')">
          Attempt Exam
        </button>
      </td>
    `;
    tbody.appendChild(row);
  });
}

function attemptExam(id, title) {
  if (attemptedExams.includes(id)) {
    const msg = document.getElementById("message");
    msg.className = "alert alert-danger";
    msg.innerHTML = `You have already attempted <b>${title}</b>. Press <b>N</b> to enable reattempt.`;
    return;
  }

  attemptedExams.push(id);
  localStorage.setItem('attemptedExams', JSON.stringify(attemptedExams));

  document.getElementById("status-" + id).innerText = "Attempted";
  document.getElementById("status-" + id).className = "text-danger";
  document.getElementById("btn-" + id).disabled = true;

  // redirect to attempt page
  window.location.href = "attmpt.html?exam=" + encodeURIComponent(title);
}

// Press N to enable reattempts
window.addEventListener("keydown", (e) => {
  if (e.key.toLowerCase() === "n") {
    // Remove attempted exams
    localStorage.removeItem('attemptedExams');
    attemptedExams = [];

    // Update each row status to "Reattempt" and enable button
    exams.forEach(exam => {
      const statusCell = document.getElementById("status-" + exam.id);
      const btn = document.getElementById("btn-" + exam.id);
      if (statusCell && btn) {
        statusCell.innerText = "Reattempt";
        statusCell.className = "text-warning";
        btn.disabled = false;
      }
    });
  }
});

// Load exams on page load
loadExams();
</script>