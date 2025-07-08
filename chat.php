<?php
include 'includes/db.php';
session_start();


//check if user loggerd in
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

//get Receipaint ID from url
if(!isset($_GET['to'])){
    echo "No Receipiant Specified";
    exit;
}


$fromUser = $_SESSION['user_id'];
$toUser = (int) $_GET['to'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    $msg = trim($_POST['message']);

    if (!empty($msg)) {
        $stmt = $conn->prepare("INSERT INTO messages (from_user, to_user, message, sent_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$fromUser, $toUser, $msg]);
        header("Location: chat.php?to=$toUser"); // refresh
        exit;
    }
}




//fetch chat mesages between both users
$stmt = $conn->prepare("
    SELECT * FROM messages
    WHERE 
        (from_user = :from AND to_user = :to)
        OR 
        (from_user = :to AND to_user = :from)
    ORDER BY sent_at ASC
");
$stmt->execute(['from' => $fromUser, 'to' => $toUser]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: white;
            padding: 20px;
        }
        .chat-box {
            background-color: #2c2c2c;
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom: 10px;
            max-width: 60%;
        }
        .from-me {
            margin-left: auto;
            text-align: right;
            background-color: #007bff;
            color: white;
        }
        .from-them {
            margin-right: auto;
            text-align: left;
            background-color: #444;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h3>💬 Chat</h3>

        <?php foreach ($messages as $msg): ?>
            <div class="chat-box <?= $msg['from_user'] == $fromUser ? 'from-me' : 'from-them' ?>">
                <?= htmlspecialchars($msg['message']) ?><br>
                <small><?= $msg['sent_at'] ?></small>
            </div>
        <?php endforeach; ?>

           <form action="" method="POST" class="mt-4">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
            <button class="btn btn-success" type="submit" name="send">Send</button>
        </div>
    </form>
</div>
</body>
</html>