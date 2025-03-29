<?php
session_start();
require_once 'backend/auth.php';

logoutUser();
header("Location: index.php");
exit;
?>