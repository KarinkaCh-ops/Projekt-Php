<?php
include_once("lib.php");
unset($_SESSION["user"]);
header('Location: login.php');
?>