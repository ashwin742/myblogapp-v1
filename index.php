<?php

include 'includes/db.php';

echo "Connected Succesfully.";


session_start();
header("Location: dashboard.php");
exit;

?>