<?php 
    $email=$_POST['inputEmail'];
    $password=$_POST['inputPassword'];
    if (!empty($email) || !empty($password)) {
        header("Location: dashboard.html");
    } else {
        header("Location: ../layanan/");
    }
    
?>