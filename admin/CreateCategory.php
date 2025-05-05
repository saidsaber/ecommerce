<?php
session_start();
include("../core/main.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    <title>admin</title>
    <title>Document</title>
</head>
<style>
    .con {
        width: 100vw;
        height: 100vh;
        display: grid;
        align-items: center;
        justify-content: space-around;
    }
    .con div{
        width: 300px;
    }
    a , a:hover{
        color: white;
        text-decoration: none;
        display: block;
        width: 100%;
        height: 100%;
    }
</style>
<body>
    <div class="con">
        <form action="../headers/CategoryName.php" method="post">
            <div class="alert alert-danger" role="alert" style="display: <?= show('catigory')?>">
                <?= error('catigory')?>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="CategoryName" placeholder="Category Name" value="<?= old('catigory')?>">
                <label for="floatingInput">Category Name</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit" name="save">
                    Create
                </button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <?php
        $_SESSION['error'] = null;
    ?>
</body>
</html>