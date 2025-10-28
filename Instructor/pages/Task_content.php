<div class="container-fluid">

        <!-- Task Form -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Create New Task</h3>
          </div>
          <form id="taskForm">
            <div class="card-body">
              <div class="form-group">
                <label>Task Title</label>
                <input type="text" class="form-control" id="taskTitle" placeholder="Enter task title" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="taskDesc" rows="3" placeholder="Enter description"></textarea>
              </div>
              <div class="form-group">
                <label>Attachment</label>
                <input type="file" class="form-control" id="taskFile" 
                  accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx,.ppsx,.jpg,.jpeg,.png,.gif,.zip,.rar">
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Marks</label>
                  <input type="number" class="form-control" id="taskMarks" placeholder="e.g. 10">
                </div>
                <div class="form-group col-md-4">
                  <label>Due Date</label>
                  <input type="date" class="form-control" id="taskDate">
                </div>
                <div class="form-group col-md-4">
                  <label>Due Time</label>
                  <input type="time" class="form-control" id="taskTime">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Task</button>
            </div>
          </form>
        </div>

        <!-- Task List -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Task List</h3>
          </div>
          <div class="card-body" id="taskList">
            <p>No tasks added yet.</p>
          </div>
        </div>

      </div>