<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if(isset($_POST['post_id']) && isset($_SESSION['user_id'])){
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];


    try{
        //check if already liked
        $check = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
        $check->execute([$user_id, $post_id]);
    
         if($check->rowCount() == 0){
            //no likes yet so can insert
            $insert = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
            $insert->execute([$user_id, $post_id]);
           echo"<script> window.location.href = 'view_post.php';</script>";

         }else if ($check->rowCount() == 1){
         echo"<script>window.location.href = 'view_post.php';</script>";

         }   
    }catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}

?>