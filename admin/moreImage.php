<?php
include('../core/config.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['saveImage'])){
    $id = $_POST['id'];
    $path = saveImage();
    $query = "INSERT INTO `image` (productId , imagePath) values ('$id' , '$path')";
    mysqli_query($conn , $query);
    header("Location: updata_Product.php");
}
function saveImage(){
    $name = (rand() . $_FILES['image']['name']);
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
        $result = move_uploaded_file($_FILES['image']['tmp_name'] , '../images/' . basename($name));
    }
    return $name;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .con {
    width: 100%;
    height: 100vh;
    display: grid
;
    align-items: center;
    justify-content: center;
}
</style>
<body>
    <div class="con">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $_POST['image']?>">
            <input type="file" name="image">
            <br>
            <input type="submit" value="send" name="saveImage">
        </form>
    </div>
</body>
</html>