<?php
session_start();


if(!isset($_SESSION['user_id'])){
    //redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $username; ?> to your Dasboard</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color: #1f1f1f;
            color: white;
            padding: 40px;
        }

        .welcome-box{
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.5);
        }

        a.btn-create{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <div class="welcome-box">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>What would you like to post about today?</p>

            <a href="create_post.php" class="btn btn-success btn-create">Create New Blog!</a>
           <a href="logout.php" class="btn btn-outline-light btn-create">Logout</a>
        </div>
    </div>
</body>
</html>