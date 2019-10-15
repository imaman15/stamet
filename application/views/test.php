<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html>

<head>
    <title>Recaptcha - harviacode.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .login-box {
            width: 300px;
            margin: auto;
            margin-top: 100px;
        }
    </style>
    <?php //echo $script_captcha; // javascript recaptcha 
    ?>
</head>

<body>
    <?= $this->session->flashdata('message');
    ?>

    <?php
    $number = "089671843158";
    $number2 = "0896 7184 3158";
    $number3 = "0896-7184-3158";
    $number4 = "(0896) 7184 3158";
    $number5 = "6289671843158";
    $number6 = "+628967184158";
    echo $number . " = " . phoneNumber($number) . "<br><br>";
    echo $number2 . " = " . phoneNumber($number2) . "<br><br>";
    echo $number3 . " = " . phoneNumber($number3) . "<br><br>";
    echo $number4 . " = " . phoneNumber($number4) . "<br><br>";
    echo $number5 . " = " . phoneNumber($number5) . "<br><br>";
    echo $number6 . " = " . phoneNumber($number6) . "<br><br>";

    ?>

    <script>
        $(".alert").alert();
    </script>
    <div class="login-box">
        <h3>Please Sign In</h3>
        <?php
        echo form_open($action);
        ?>
        <div class="form-group">
            <label>Username</label>
            <?php echo form_input('username', $username, 'class="form-control"'); ?>
            <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
        </div>
        <div class="form-group">
            <label>Password</label>
            <?php echo form_password('password', $password, 'class="form-control"'); ?>
            <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
        </div>
        <div class="form-group">
            <?php echo $captcha // tampilkan recaptcha 
            ?>
            <?= form_error('g-recaptcha-response', '<small class="text-danger pl-3">', '</small>') ?>
        </div>
        <div class="form-group">
            <?php echo form_submit('login', 'login', 'class="btn btn-primary"'); ?>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>