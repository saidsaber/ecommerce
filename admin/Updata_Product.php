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
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .btns-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 8px;
        padding: 0 15px 15px;
        justify-items: stretch;
    }


    .container {
        max-width: 1200px;
        margin: auto;
        padding: 40px 20px;
    }

    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .card img {
        width: 100%;
        max-height: 240px;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
        text-align: center;
    }

    .card-body h5 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: #333;
    }

    .card-body .price {
        color: #2c3e50;
        font-weight: bold;
    }

    .btns {
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 8px;
        padding: 0 10px 15px;
    }

    button.btn {
        padding: 8px 12px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #3498db;
        color: white;
        transition: background 0.2s ease;
    }

    button.btn:hover {
        background-color: #2980b9;
    }

    button.btn.delete {
        background-color: #e74c3c;
    }

    button.btn.delete:hover {
        background-color: #c0392b;
    }

    @media (max-width: 768px) {

        .row-cols-2,
        .row-cols-md-3,
        .row-cols-xl-4 {
            grid-template-columns: repeat(1, 1fr) !important;
        }
    }
</style>

<body>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="product-grid"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                <?php
                // $query = "SELECT * FROM `products` LEFT JOIN favorite ON products.productId = favorite.productId;";
                $query = "SELECT products.productId , products.userId , products.cateId , products.productName , products.price , products.discription , favorite.favId FROM `products` LEFT JOIN favorite ON products.productId = favorite.productId;";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)):
                    $productId = $row['productId'];
                    $query1 = "SELECT * FROM `image` WHERE productId = '$productId'";
                    $result1 = mysqli_query($conn, $query1);
                    ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <?php
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                $image = $row1['imagePath'];
                                echo "<img src='../images/$image' alt='Product Image'>";
                                break;
                            }
                            ?>
                            <div class="card-body">
                                <h5><?= $row['productName'] ?></h5>
                                <div class="price"><?= $row['price'] ?> EGP</div>
                            </div>
                            <div class="btns-grid">
                                <form action="update.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['productId'] ?>">
                                    <button class="btn">Update</button>
                                </form>
                                <form action="detiales/color.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['productId'] ?>">
                                    <button class="btn">Add Color</button>
                                </form>
                                <form action="moreImage.php" method="">
                                    <input type="hidden" name="productId" value="<?= $row['productId'] ?>">
                                    <button class="btn">Add Image</button>
                                </form>
                                <form action="detiales/size.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['productId'] ?>">
                                    <button class="btn">Add Size</button>
                                </form>
                                <form action="#" method="post">
                                    <button class="btn delete">Delete</button>
                                </form>
                                <form action="detiales/count.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['productId'] ?>">
                                    <button class="btn">Add Count</button>
                                </form>
                                
                            </div>


                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</body>

</html>