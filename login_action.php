<?php
$guestpage=true;
include("./includes/config.php");
extract($_REQUEST);
//exit;

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

$authenticated = false;

while ($row = mysqli_fetch_assoc($result)) {
    if ($username === $row['user_name'] && $password === $row['password']) {
        $_SESSION["userid"] = $row['user_id'];
        $_SESSION["username"] = $row['user_name'];
        $_SESSION["login_time_stamp"] = time();
        $authenticated = true;
        break; 
    }
}

if ($authenticated) {
    header("Location: index1.php");
    exit(); 
} else {
    header("Location: login.php?error=1");
    exit(); 
}
?>