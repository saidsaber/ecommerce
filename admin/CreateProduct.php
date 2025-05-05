<?php
session_start();
include("../core/main.php");
include("../core/config.php");


$query = "SELECT * FROM catigory";
$res = mysqli_query($conn , $query);
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
    body{
        margin: 0;
        padding: 50px 0;
        overflow-x: hidden;
    }
    .con {
        width: 100vw;
        height: 100%;
        display: grid;
        align-items: center;
        justify-content: space-around;
    }
    .con .div{
        width: 90vw;
    }
    a , a:hover{
        color: white;
        text-decoration: none;
        display: block;
        width: 100%;
        height: 100%;
    }
    select#inputGroupSelect01 {
        width: calc(90vw - 81px);
        box-sizing: border-box;
        outline: none;
        border: 1px solid #ced4da;
        height: calc(3.5rem + 2px);
        border-radius: .25rem;
    }
    label.input-group-text{
        height: calc(3.5rem + 2px);
        border-radius: .25rem;   
    }
    label.custom-file-label{
        height: calc(3.5rem + 2px);
        border-radius: .25rem;
        border: 1px solid #ced4da;
        width: 90vw;
        display: flex;
        align-items: center;
        flex-direction: row;
        align-content: center;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 10vw;
        padding: 12px;
    }
</style>
<body>
    <div class="con">
        <form action="../headers/CreateProduct.php" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Product Name" value="<?= old('ProductName')?>">
                <label for="ProductName">Product Name</label>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('ProductName')?>">
                <?= error('ProductName')?>
            </div>
            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="Price" name="Price" placeholder="Price" value="<?= old('Price')?>">
                <label for="Price">Price</label>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('Price')?>">
                <?= error('Price')?>
            </div>
            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="NumberOfPieces" name="NumberOfPieces" placeholder="NumberOfPieces" value="<?= old('NumberOfPieces')?>">
                <label for="NumberOfPieces">Number Of Pieces</label>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('NumberOfPieces')?>">
                <?= error('NumberOfPieces')?>
            </div>
            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="ditials" name="ditials" placeholder="ditials" value="<?= old('ditials')?>">
                <label for="ditials">ditials</label>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('ditials')?>">
                <?= error('ditials')?>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="category">
                    <option selected value="-1">Choose...</option>
                    <?php
                    while($row = mysqli_fetch_assoc($res)):
                    ?>
                    <option value="<?= $row['cateId']?>" <?= (old('category') == $row['cateId']) ?'selected' : null?>><?= $row['cateName']?></option>
                    <?php endwhile?>
                </select>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('category')?>">
                <?= error('category')?>
            </div>
            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="Title" name="Title" placeholder="Title" value="<?= old('Title')?>">
                <label for="Title">Title</label>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('Title')?>">
                <?= error('Title')?>
            </div>
            <div class="form-floating mb-3 div">    
                <textarea class="form-control" id="Description" rows="3" placeholder="Description" name="Description"><?= old('Description')?></textarea>
                <label for="Description">Description</label>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('Description')?>">
                <?= error('Description')?>
            </div>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" style="display:none"id="inputGroupFile03" name="image">
                    <label class="custom-file-label" for="inputGroupFile03">
                        Choose file 
                        <span id="path">
                            Choose File
                        </span>
                    </label>
                </div>
            </div>
            <div class="alert alert-danger" role="alert" style="display: <?= show('image')?>">
                <?= error('image')?>
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
        // echo '<pre>';
        // print_r($_SESSION['error']);
        $_SESSION['error'] = null;
    ?>
    <script>
        let path = document.getElementById("path");
        document.getElementById("inputGroupFile03").addEventListener("change", function(e) {
            const file = e.target.files[0];
            console.log("مسار الملف:", file.name);
            path.innerText = file.name;
        });
    </script>
</body>
</html>