<?php

include("./includes/config.php");
extract($_REQUEST);

if($op_code == 1)
{
    $sql = "UPDATE users SET `password` = '$new_password' where  `password` = '$current_password' AND user_id = '$_SESSION[userid]'";

    $result =  mysqli_query($conn,$sql);

    if(mysqli_affected_rows($conn) > 0)
    {
        echo "Password changed Successfully";
    }
    else
    {
        echo "current Password is Wrong";
    }
}
?>