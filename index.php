<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GCUH Testing System</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="logo2.png" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="login-box">
      <img src="logo2.png" alt="Logo" class="logo" />
      <h2>Department of IT</h2>
      <p class="portal">LMS Portal</p>

      <form action="auth/login.php" method="POST">
        <input type="text" name="username" placeholder="Enter Username or Email" required />
        <input type="password" name="password" placeholder="Enter Password" required />
        <button type="submit">Sign In</button>
      </form>
      
      <p class="footer-text">
        Contact <strong>Mr. Nizakat Hussain</strong> or <strong>Mr. Asif</strong><br />
        for Login ID & Password
      </p>
    </div>
  </div>
</body>
</html>
