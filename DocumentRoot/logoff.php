<?php
session_start();
if($_SESSION["deleted"]){
    $_SESSION = array();
    $_SESSION["deleted"] = 1;
    header("location: index.php");
}else if($_SESSION["loggedOff"]){
    $_SESSION = array();
    $_SESSION["loggedOff"] = 1;
    header("location: index.php");
}else{
    $_SESSION = array();
    session_destroy();
    header("location: index.php");
}
?>