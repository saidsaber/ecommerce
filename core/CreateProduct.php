<?php
include('validation.php');
include('config.php');

$_SESSION['error'] = [];
function isRequired($ProductData){
    $isError = false;
    foreach($ProductData as $field => $value){
        if($field == 'category'){
            continue;
        }
        if(required($value , $field) != 1){
            $isError = true;
        }
        $_SESSION['error'] += [$field => [required($value , $field) , $value]];
    }
    if($ProductData['category'] == -1){
        $isError = true;
        $_SESSION['error'] += ['category' => ['please check a category' , $ProductData['category']]];
    }
    $_SESSION['error'] += ['category' => [1 , $ProductData['category']]];
    return $isError;
}

function lengthMoreFour($ProductData){
    $_SESSION['error'] = [];
    $isError = isNum($ProductData);
    foreach($ProductData as $field => $value){
        if($field == 'category' || $field == 'NumberOfPieces' ||$field == 'Price' || $field == 'ditials'){
            continue;
        }
        if(length($value , $field) != 1){
            $isError = true;
        }
        $_SESSION['error'] += [$field => [length($value , $field) , $value]];
    }
    $_SESSION['error'] += ['category' => [1 , $ProductData['category']]];
    return $isError;
}

function isNum($ProductData){
    $isError = false;
    if(!is_numeric($ProductData['Price']) || $ProductData['Price'] < 1){
        $_SESSION['error'] += ['Price' => ['this field must be numeric more than 0' , $ProductData['Price'] ]];
        $isError = true;
    }
    $_SESSION['error'] += ['Price' => [1 , $ProductData['Price'] ]];

    if(!is_numeric($ProductData['NumberOfPieces']) || $ProductData['NumberOfPieces'] < 1){
        $_SESSION['error'] += ['NumberOfPieces' => ['this field must be numeric more than 0' , $ProductData['NumberOfPieces']]];
        $isError = true;
    }
    $_SESSION['error'] += ['NumberOfPieces' => [1 , $ProductData['NumberOfPieces']]];
    return $isError;
}
function image($ProductData){
    lengthMoreFour($ProductData);
    $isError = false;
    if(strlen($_FILES['image']['name']) == 0 ){
        $isError = true;
        $_SESSION['error'] += ['image' => ['please upload image', 1]];
    }

    return $isError;
}

function saveImage($ProductData){
    $name = (rand() . $_FILES['image']['name']);
    $ProductData += ['path' => $name];
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
        $result = move_uploaded_file($_FILES['image']['tmp_name'] , '../images/' . basename($name));
    }
    return $ProductData;
}

function validation($ProductData){
    if(isRequired($ProductData)){
        header("Location: ../admin/CreateProduct.php");
        exit;
    }
    if(lengthMoreFour($ProductData)){
        header("Location: ../admin/CreateProduct.php");
        exit;
    }
    if(image($ProductData)){
        header("Location: ../admin/CreateProduct.php");
        exit;
    }
    $ProductData = saveImage($ProductData);
    saveDataInDataBase($ProductData);
    header("Location: ../admin/CreateProduct.php");
    exit;
}

function saveDataInDataBase($ProductData){
    $userId = $_SESSION['user'];
    $ProductName = $_POST['ProductName'];
    $Price = $ProductData['Price'];
    $NumberOfPieces = $ProductData['NumberOfPieces'];
    $category = $ProductData['category'];
    $Title = $ProductData['Title'];
    $Description = $ProductData['Description'];
    $imagePath = $ProductData['path'];

    $query = "INSERT INTO products ( `userId`, `cateId`, `productName`, `price`, `discription`) VALUES
    ('$userId' , '$category' , '$ProductName' , '$Price' , '$Description')";
    mysqli_query($GLOBALS['conn'] , $query);

    $primaryId = $GLOBALS['conn']->insert_id;
    addDetails($ProductData , $primaryId);
    $query = "INSERT INTO `image` (productId ,imagePath ) VALUES ('$primaryId' , '$imagePath')";
    mysqli_query($GLOBALS['conn'] , $query);
}

function addDetails($ProductData , $productId){
    $detail = explode(',' , $ProductData['ditials']);

    $detailData = [];
    $i = 1;
    foreach($detail as $value){
        $size =explode('-' , $value)[0];
        $color =explode('-' , $value)[1];
        $count =explode('-' , $value)[2];

        $detailData +=[
            $i =>[
                'size' => $size,
                'color' => $color,
                'count' => $count
            ],
        ];
        $i++;
    }
    foreach($detailData as $detailDat){
        $query = "INSERT INTO productinfo (productId , count , size , color) value
         ('$productId' , '{$detailDat['count']}' , '{$detailDat['size']}' , '{$detailDat['color']}')";
         mysqli_query($GLOBALS['conn'] , $query);
    }
}