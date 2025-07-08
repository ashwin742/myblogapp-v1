<?php
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if(isset($_POST['register'])){
    //Grab Data from form submit
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];


    //Validation
    if($password !== $cpassword){
        echo "<script>alert('loha');</script>";
    }else{
        //hash the password
        $hashed_Password = password_hash($password, PASSWORD_DEFAULT);
    }

    try{
            //Insert into DB
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
            $stmt->execute([$username, $email, $hashed_Password]);
            echo "<script>alert('Registration Successfull'); window.location.href = 'login.php';</script>";
    }catch(PDOException $e) {
        //if any duplicate username/emails
        if($e->getCode() == 23000){
             echo "<script>alert('Username or email already exists');</script>";
        }else{
            echo "Error: " .$e->getMessage();
        }

    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/blog-app/assets/style.css">
    <title>Register Page</title>
</head>
<body>

<div class="form-container">
    <h3 class="text-center mb-4">Register Here</h3>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cpassword">Confirm Passowrd</label>
            <input type="password" name="cpassword" class="form-control" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary w-100">Register Now</button>
    </form>
</div>
    
</body>
</html>