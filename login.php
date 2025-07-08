<?php
include 'includes/db.php';
session_start();

if(isset($_POST['login'])){
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  //check if email already exist
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if($user){
    //verify password
    if(password_verify($password, $user['password'])){
      //start sesssion
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];


      //redirect
      header("Location: dashboard.php");
      exit;
    }else{
      echo "<script>alert('Incorrect Password');</script>";
    }
  }else{
    echo "<script>alert('Email not found');</script>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
        body{
          background-color: #1f1f1f;
          color: white;
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        .form-container{
          background-color: #2c2c2c;
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0px 0px 15px rgba(0,0,0,0.5);
          width: 100%;
          max-width: 400px;
        }
        label{
          color: #ccc;
        }
      </style>

</head>
<body>
    <div class="form-container">
      <h3 class="text-center mb-4">Login Here</h3>
      <form action="" method="POST">
        <div class="mb-3">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>

      </form>
    </div>
</body>
</html>