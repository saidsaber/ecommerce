<?php
include("../core/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updata Product</title>
</head>
<style>
    .card.h-100 {
        display: flex;
        flex-direction: row;
        align-content: center;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-around;
        margin-bottom: 5px;
        border: 1px solid black;
        border-radius: 5px;
        padding: 5px;
    }
    form{
        margin-bottom: 5px;
    }
    img{
        max-width: 360px;
    }
    button.btn.btn-outline-dark.mt-auto {
        border: none;
        box-sizing: border-box;
        width: 125px;
        padding: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<body>
<section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    // $query = "SELECT * FROM `products` LEFT JOIN favorite ON products.productId = favorite.productId;";
                    $query = "SELECT products.productId , products.userId , products.cateId , products.productName , products.price , products.discription , favorite.favId FROM `products` LEFT JOIN favorite ON products.productId = favorite.productId;";
                    $result = mysqli_query($conn , $query);
                    while($row = mysqli_fetch_assoc($result)):
                        $productId = $row['productId'];
                        $query1 = "SELECT * FROM `image` WHERE productId = '$productId'";
                        $result1 = mysqli_query($conn , $query1);
                    ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                             <?php
                                while($row1 = mysqli_fetch_assoc($result1)){
                                    $image = $row1['imagePath'];
                                    echo "<img class='card-img-top' src='../images/$image' alt='...' />";
                                    break;
                                }
                             ?>
                            
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?= $row['productName']?></h5>
                                    <?= $row['price'] ?> EGP
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="btns">
                                <div class="text-center">
                                    <form action="update.php" method="post" >
                                        <input type="hidden" name="id" value="<?= $row['productId']?>">
                                        <button class="btn btn-outline-dark mt-auto" name="send">
                                            update
                                        </button>
                                    </form>
                                    <form action="moreImage.php" method="post">
                                        <input type="hidden" name="image" value="<?= $row['productId']?>">
                                        <button class="btn btn-outline-dark mt-auto" >
                                            add image
                                        </button>
                                    </form>
                                    <form action="#" method="post">
                                        <button class="btn btn-outline-dark mt-auto" style="background: red; color: white">
                                            delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;?>
                </div>
            </div>
        </section>
</body>
</html>