<?php
require_once("database.php");
if(!empty($_POST["user_id"]))
{
$query =mysqli_query($con,"Delete FROM users WHERE user_id = '" . $_POST["user_id"] . "'");
}
?>
