<?php 
require_once('core/config.php');
require_once('inc/header.php');

// تحقق من دخول المستخدم
if (!isset($_SESSION['user'])) {
    echo "
        <div class='alert alert-danger text-center'>
            يجب عليك <a href='login.php'>تسجيل الدخول</a> أولاً
        </div>
    ";
    exit;
}

$userId = $_SESSION['user'];

// حذف منتج من السلة
if (isset($_GET['delid'])) {
    $cartId = (int)$_GET['delid'];
    $query = "DELETE FROM cart WHERE cartId = $cartId AND userId = $userId";
    mysqli_query($conn, $query);
    header("Location: cart.php");
    exit;
}
?>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }
        
        .products-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .product-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            cursor: pointer;
        }
        
        .product-content {
            padding: 1.5rem;
        }
        
        .product-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }
        
        .product-price {
            font-size: 1.25rem;
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        
        .btn-details {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .btn-details:hover {
            background-color: var(--secondary-color);
            color: white;
        }
        
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        tr.th {
            background: var(--secondary-color);
        }
    </style>
<!-- رأس الصفحة -->
<header class="products-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">منتجاتنا</h1>
            <p class="lead">اكتشف أحدث منتجاتنا بأسعار تنافسية</p>
        </div>
    </header>

<!-- محتوى السلة -->
<section class="py-5">
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="">
                    <tr class="th">
                        <th>#</th>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>المقاس</th>
                        <th>اللون</th>
                        <th>الإجمالي</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total = 0;
                        $query = "SELECT cart.*, products.*  
                                  FROM cart 
                                  INNER JOIN products ON cart.productId = products.productId  
                                  WHERE cart.userId = '$userId' AND cart.shipmentId = 0";
                        $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_assoc($result)):
                            $itemTotal = $row['price'] * $row['count'];
                            $total += $itemTotal;
                    ?>
                    <tr>
                        <td><?= ++$i ?></td>
                        <td><?= htmlspecialchars($row['productName']) ?></td>
                        <td><?= $row['price'] ?> جنيه</td>
                        <td><input type="number" class="form-control" value="<?= $row['count'] ?>" disabled></td>
                        <td>غير محدد</td>
                        <td>غير محدد</td>
                        <td><?= $itemTotal ?> جنيه</td>
                        <td><a href="?delid=<?= $row['cartId'] ?>" class="btn btn-sm btn-danger">حذف</a></td>
                    </tr>
                    <?php endwhile; ?>
                    <tr class="table-light fw-bold">
                        <td colspan="6" class="text-end">الإجمالي الكلي:</td>
                        <td colspan="2"><?= $total ?> جنيه</td>
                    </tr>
                </tbody>
            </table>

            <?php if($total > 0): ?>
                <div class="text-end mt-3">
                    <a href="checkout.php" class="btn btn-success">متابعة الدفع</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once('inc/footer.php'); ?>
