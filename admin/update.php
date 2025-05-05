<?php
include("../core/config.php");
include("../core/main.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $query = "SELECT * FROM products where productId = '$id'" ;
    $res = mysqli_query($conn , $query);
    $result = mysqli_fetch_assoc($res);
}else{
    header("Location: ../index.php");
    exit;
}

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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Product Name" value="<?= $result['productName']?>">
                <label for="ProductName">Product Name</label>
            </div>

            <div class="form-floating mb-3 div">
                <input type="text" class="form-control" id="Price" name="Price" placeholder="Price" value="<?= $result['price']?>">
                <label for="Price">Price</label>
            </div>

            <div class="form-floating mb-3 div">    
                <textarea class="form-control" id="Description" rows="3" placeholder="Description" name="Description"><?= $result['discription']?></textarea>
                <label for="Description">Description</label>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit" name="save">
                    update
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