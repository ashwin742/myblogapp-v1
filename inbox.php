<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];


// Get distinct chat partners
$stmt = $conn->prepare("
    SELECT 
        m.to_user AS chat_with, 
        u.username,
        (SELECT message FROM messages 
         WHERE (from_user = :user OR to_user = :user) 
         AND (from_user = u.user_id OR to_user = u.user_id)
         ORDER BY sent_at DESC LIMIT 1) AS last_msg
    FROM messages m
    JOIN users u ON u.user_id = m.to_user
    WHERE m.from_user = :user
    GROUP BY m.to_user
");
$stmt->execute(['user' => $userId]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
   body {
      background-color: #1f1f1f;
      color: white;
      padding: 40px;
    }
    .inbox-item {
      background-color: #2c2c2c;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    a {
      text-decoration: none;
      color: #00d1ff;
    }
      </style>

</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h2>Your Inbox</h2>
        <?php foreach ($chats as $chat): ?>
            <div class="inbox-item">
                <strong><?php echo htmlspecialchars($chat['username']); ?></strong>
                <small><?php echo htmlspecialchars($chat['last_msg']); ?></small>
                 <a href="chat.php?to=<?= $chat['chat_with']; ?>">Open Chat</a>

            </div>
            <?php endforeach; ?>
             <a href="dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
    </div>
</body>
</html>