
  <style>
    body { background: #f4f6f9; }

    /* Profile Card */
    .profile-card {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 30px;
    }

    .profile-img {
      width: 130px;
      height: 130px;
      object-fit: cover;
      border-radius: 80%;
      border: 3px solid #28a745;
      margin-bottom: 15px;
    }

    .edit-btn {
      font-size: 14px;
      padding: 8px 12px;
    }

    /* Toast Notification */
    #toastContainer { position: fixed; top: 20px; right: 20px; z-index: 1050; }
    .toast { min-width: 250px; margin-bottom: 10px; }
  </style>


<div class="profile-card text-center">
        <img src="/Profile.jpg" alt="Profile Picture" class="profile-img" id="profileImage">
        <h3 id="userName">Admin</h3>
        <p class="text-muted" id="userRole">Administrator</p>

        <hr>

        <form id="profileForm">
          <div class="form-group text-left">
            <label>Full Name</label>
            <input type="text" class="form-control" id="fullName" value="John Doe">
          </div>

          <div class="form-group text-left">
            <label>Email</label>
            <input type="email" class="form-control" id="email" value="admin@example.com">
          </div>

          <div class="form-group text-left">
            <label>Phone</label>
            <input type="text" class="form-control" id="phone" value="+92 300 1234567">
          </div>

          <div class="form-group text-left">
            <label>Change Profile Picture</label>
            <input type="file" class="form-control-file" id="profileUpload">
          </div>
          <button type="submit" class="btn btn-block edit-btn" id="saveBtn" style="background-color:#69263a; border-color:#69263a; color:#fff;">
            <i class="fas fa-save"></i> Save Changes
          </button>

        </form>
      </div>


      <script>
  // Profile Image Preview
  document.getElementById("profileUpload").addEventListener("change", function(){
    const file = this.files[0];
    if(file){
      const reader = new FileReader();
      reader.onload = function(e){
        document.getElementById("profileImage").setAttribute("src", e.target.result);
      }
      reader.readAsDataURL(file);
    }
  });

  // Toast Notification
  function showToast(message){
    const toast = $(`
      <div class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">${message}</div>
      </div>
    `);
    $("#toastContainer").append(toast);
    toast.toast({delay:2000});
    toast.toast("show");
    toast.on("hidden.bs.toast", ()=> toast.remove());
  }

  // Save Changes
  document.getElementById("profileForm").addEventListener("submit", function(e){
    e.preventDefault();
    const fullName = document.getElementById("fullName").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    document.getElementById("userName").textContent = fullName;
    showToast("Profile updated successfully!");
  });
</script>``