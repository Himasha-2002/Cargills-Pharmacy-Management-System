<?php 
session_start();
session_destroy();

header("location:./Naduni/index.php");
?>