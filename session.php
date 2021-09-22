<?php

require_once './php/config.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');	
    ?>
    <script>
    javascript:alert('Você não está logado!');
    javascript:window.location='../login.html';
    </script>
    <?php
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
  // last request was more than 30 minutes ago
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
  header('Location: login.html');
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

$email=$_SESSION['name'];
$sql = "SELECT name FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    $nome = $row['name'];  
    }
} else { 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello <?php echo $nome ?> <br></h1>
    <h1><a href='./php/logout.php'>Logout -></a></h1>
</body>
</html>