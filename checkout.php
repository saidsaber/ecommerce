<?php 
 require_once('inc/header.php');
 require_once('core/main.php');
 ?>
<style>
    ul li p{
        display: inline;
    }
</style>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-4">
                <div class="border p-2">
                    <div class="products">
                        <ul class="list-unstyled">
                            <?php
                                $total = 0;
                                $query = "SELECT cart.* , products.*  FROM `cart` INNER JOIN products on(cart.productId = products.productId)  where cart.userId = '{$_SESSION['user']}' and cart.shipmentId = 0 ";
                                $result = mysqli_query($conn , $query);
                                while($row = mysqli_fetch_assoc($result)):
                                    $total += ($row['price'] * $row['count']);
                                    // print_r($row);
                            ?>
                            <li class="border p-2 my-1"> <p><?= $row['productName']?></p> -
                                <p class="text-success mx-2 mr-auto bold"><?= $row['count']?> x <?= $row['price']?> EGP</p>
                            </li>
                            <?php endwhile;?>
                        </ul>
                    </div>
                    <h3>Total : <?= $total?> EGP</h3>
                </div>
            </div>
            <div class="col-8">
                <form action="headers/shipment.php" method="post" class="form border my-2 p-3">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="Name" id="" class="form-control" value="<?= old('Name')?>">
                            <div class="alert alert-danger" role="alert" style="display: <?= show('Name')?>">
                                <?= error('Name')?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" name="Email" id="" class="form-control" value="<?= old('Email')?>">
                            <div class="alert alert-danger" role="alert" style="display: <?= show('Email')?>">
                                <?= error('Email')?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Address</label>
                            <input type="text" name="Address" id="" class="form-control" value="<?= old('Address')?>">
                            <div class="alert alert-danger" role="alert" style="display: <?= show('Address')?>">
                                <?= error('Address')?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Phone</label>
                            <input type="text" name="Phone" id="" class="form-control" value="<?= old('Phone')?>">
                            <div class="alert alert-danger" role="alert" style="display: <?= show('Phone')?>">
                                <?= error('Phone')?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Notes</label>
                            <input type="text" name="Notes" id="" class="form-control" value="<?= old('Notes')?>">
                            <div class="alert alert-danger" role="alert" style="display: <?= show('Notes')?>">
                                <?= error('Notes')?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Send" id="" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once('inc/footer.php');
$_SESSION['error'] = null;
?>