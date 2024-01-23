<?php 
session_start();
unset($_SESSION['controle_vb']);unset($_SESSION['usr_id']);header('location:../sistema');exit();
?> 