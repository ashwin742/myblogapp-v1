<?php
include 'includes/db.php';
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}


if(isset($_POST['post'])){
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if(!empty($title) && !empty($content)){
        try{
            $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?,?,?)");
            $stmt->execute([$user_id, $title, $content]);
            echo"<script>alert('Post Published Succesfully!'); window.location.href = 'dashboard.php';</script>";

        }catch(PDOException $e){
          echo"Error: " . $e->getMessage();
        }
    }else{
        echo"<script>alert('Pill dont leave the fields empty!');";
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Post</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color: #1f1f1f;
            color: white;
            padding: 40px;
        }

        .form-box{
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            max-width: 700px;
            margin: auto;
        }

        label{
            color: #ccc;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="form-box">
        <h2>Create a new Blog post</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label>Post Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="6" class="form-control" required></textarea>
            </div>
            <button type="submit" name="post" class="btn btn-primary">Publish</button>
            <a href="dashboard.php" class="btn btn-secondary">Back To Dashboard</a>
        </form>
    </div>

</body>
</html>