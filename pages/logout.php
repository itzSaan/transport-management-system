<?php 
session_start();
include('../config/config.php');
$_SESSION['user'] == '';
session_unset();
session_destroy();

?>

<script> document.location = '../index.php'</script>