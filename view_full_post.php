<?php
include 'includes/db.php';
session_start();

if(!isset($_GET['id'])){
    header("Location: view_post.php");
    exit;
}


$post_id = $_GET['id'];


//get post + creator
$stmt = $conn->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.user_id WHERE posts.post_id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$post){
    echo 'Post not found!';
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          body{
            background-color: #1f1f1f;
            color: white;
            padding: 40px;
          }

          .post-box{
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
          }

          h2, small{
            color: #ccc;
          }
        </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>
        <div class="post-box">
            <h2><?php echo htmlspecialchars($post['title']); ?></h2>
             <small>By <?= htmlspecialchars($post['username']) ?> on <?= $post['created_at'] ?></small>
    <hr>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <a href="view_post.php" class="btn btn-secondary mt-3">Back</a>
        </div>
</body>
</html>