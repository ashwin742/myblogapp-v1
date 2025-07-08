<?php

include 'includes/db.php';
session_start();



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
} 


$currentUserId = $_SESSION['user_id'];

//fetch all users except the one logged in...meaning current logged in user
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id != ?");
$stmt->execute([$currentUserId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Messages</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
      body{
        background: #1f1f1f;
        color: white;
        padding: 40px;
      }

      .user-box{
        background-color: #2c2c2c;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
      }

      a{
        text-decoration: none;
        color: #00d1ff;
      }


     </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Send a Message</h2>
    <?php foreach ($users as $user): ?>
    <div class="user-box">
        <strong><?php echo htmlspecialchars($user['username']) ?></strong><br>
        <a href="chat.php?to=<?php echo $user['user_id']; ?>">Send Message</a>
    </div>
    <?php endforeach; ?>


    <a href="dashboard.php" class="btn btn-secondary mt-4">Back To Dashboard</a>

</div>
    
</body>
</html>