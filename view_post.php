<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.user_id ORDER BY posts.created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Feed</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
            body{
                background-color: #1f1f1f;
                color: white;
                padding: 40px;
            }

            .post-card{
                background-color: #2c2c2c;
                margin-bottom: 20px;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.4);

            }

            .post-card h4, .post-card p, .post-card small{
                color: #ccc;
            }
            
      </style>

</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h2 class="mb-4">All Blog Posts</h2>

    <?php foreach ($posts as $post): ?>
  <div class="post-card">
    <h4><?= htmlspecialchars($post['title']) ?></h4>
    <small>By <?= htmlspecialchars($post['username']) ?> on <?= $post['created_at'] ?></small>
    <p><?= substr(htmlspecialchars($post['content']), 0, 150) ?>...</p>
    <form method="POST" action="like.php" class="mt-2">
        <input type="hidden" name="post_id" value="<?= $post['post_id']?>">
        <button type="submit" class="btn btn-sm btn-outline-danger">❤️ Like</button>
        <?php 
            //count total likes for this post
            $countStmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
            $countStmt->execute([$post['post_id']]);
            $likeCount = $countStmt->fetchColumn();
            if (!$likeCount){ $likeCount = 0; }// Set default if no likes
        ?>
        <span class="ms-2"><?= $likeCount ?> <?= $likeCount == 1 ? "like" : "likes" ?></span>
            <a href="view_full_post.php?id=<?= $post['post_id'] ?>" class="ms-2">Read Full Post</a>



    </form>
    
  </div>
<?php endforeach; ?>
            <a href="dashboard.php" class="btn btn-secondary mt-3">Back To Dashboard</a>
    </div>
</body>
</html>          