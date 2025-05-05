<?php
session_start();
include("core/main.php");  
if(isset($_SESSION['user'])):
    header("Location: index.php");
    exit;
else:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<style>
    form {
    max-width: 330px;
    min-width: 240px;
    }
    .con {
        width: 100vw;
        height: 100vh;
        display: grid;
        align-items: center;
        justify-content: center;
    }
</style>
<body>
    <div class="con">
        <form method="post" action="headers/login.php">
            <div class="alert alert-danger" role="alert" style="display: <?= passOrMail() == null ? 'none':'block' ?>">
                <?= passOrMail()?>
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="<?= old('email')?>">
                <div class="alert alert-danger" role="alert" style="display: <?= show('email')?>">
                    <?= error('email')?>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password"  value="<?= old('password')?>">
                <div class="alert alert-danger" role="alert" style="display: <?= show('password')?>">
                    <?= error('password')?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <p>
                انا لا املك حساب
                <a href="register.php">انشاء حساب</a>
            </p>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php endif; $_SESSION['error'] = null?>