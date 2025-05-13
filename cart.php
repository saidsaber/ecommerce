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
    $cartId = (int) $_GET['delid'];
    $query = "DELETE FROM cart WHERE cartId = $cartId AND userId = $userId";
    mysqli_query($conn, $query);
    header("Location: cart.php");
    exit;
}
?>
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4895ef;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --danger-color: #e63946;
        --success-color: #4cc9f0;
    }

    body {
        font-family: 'Tajawal', sans-serif;
        background-color: #f5f7fa;
        color: var(--dark-color);
    }

    .cart-header {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 20px rgba(67, 97, 238, 0.15);
    }

    .cart-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 3rem;
    }

    .cart-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .cart-table thead th {
        background-color: var(--primary-color);
        color: white;
        padding: 1.2rem;
        font-weight: 600;
        text-align: center;
    }

    .cart-table tbody td {
        padding: 1.2rem;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .cart-table tbody tr:last-child td {
        border-bottom: none;
    }

    .cart-table tbody tr:hover {
        background-color: rgba(72, 149, 239, 0.05);
    }

    .product-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .product-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #eee;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--light-color);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
    }

    .quantity-btn:hover {
        background-color: var(--accent-color);
        color: white;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0.3rem;
    }

    .delete-btn {
        color: var(--danger-color);
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .delete-btn:hover {
        transform: scale(1.2);
    }

    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px solid #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .checkout-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .checkout-btn:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 0;
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 1.5rem;
    }

    .continue-shopping {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-top: 1rem;
    }

    .continue-shopping:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .cart-table thead {
            display: none;
        }

        .cart-table tbody tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 1rem;
        }

        .cart-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            padding: 0.8rem;
            border-bottom: 1px solid #eee;
        }

        .cart-table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 1rem;
            color: var(--primary-color);
        }

        .product-info {
            justify-content: space-between;
            width: 100%;
        }
    }
</style>

<!-- رأس الصفحة المحدث -->
<header class="cart-header">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">سلة التسوق</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">الرئيسية</a></li>
            </ol>
        </nav>
    </div>
</header>

<!-- محتوى السلة المحدث -->
<section class="py-4">
    <div class="container">
        <?php
        $query = "SELECT 
                cart.*, 
                products.*, 
                color.*,
                size.*
            FROM 
                cart 
            INNER JOIN 
                products ON cart.productId = products.productId 
            LEFT JOIN 
                color ON cart.colorId = color.colorId 
            LEFT JOIN 
                size ON cart.sizeId = size.sizeId
            WHERE 
                cart.userId = $userId 
                AND cart.shipmentId = 0";
        $result = mysqli_query($conn, $query);
        $itemCount = mysqli_num_rows($result);
        ?>

        <?php if ($itemCount > 0): ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-container">
                        <div class="table-responsive">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المنتج</th>
                                        <th>السعر</th>
                                        <th>الكمية</th>
                                        <th>المقاس</th>
                                        <th>اللون</th>
                                        <th>الإجمالي</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $total = 0;
                                    while ($row = mysqli_fetch_assoc($result)):
                                        $itemTotal = $row['price'] * $row['count'];
                                        $total += $itemTotal;
                                        ?>
                                        <tr>
                                            <td data-label="#"><?= ++$i ?></td>
                                            <td data-label="المنتج">
                                                <div class="product-info">
                                                    <?php if (!empty($row['productImage'])): ?>
                                                        <img src="uploads/<?= htmlspecialchars($row['productImage']) ?>"
                                                            alt="<?= htmlspecialchars($row['productName']) ?>" class="product-img">
                                                    <?php endif; ?>
                                                    <span><?= htmlspecialchars($row['productName']) ?></span>
                                                </div>
                                            </td>
                                            <td data-label="السعر"><?= number_format($row['price'], 2) ?> ج.م</td>
                                            <td data-label="الكمية">
                                                <div class="quantity-control">
                                                    <input type="number" class="form-control quantity-input"
                                                        value="<?= $row['count'] ?>" min="1" disabled>
                                                </div>
                                            </td>
                                            <td data-label="المقاس"><?= empty($row['sizeName']) ? '--' : $row['sizeName'] ?>
                                            </td>
                                            <td data-label="اللون">
                                                <?php if (!empty($row['colorName'])): ?>
                                                    <span
                                                        style="display: inline-block; width: 20px; height: 20px; background-color: <?= $row['colorHexCode'] ?>; border-radius: 50%; border: 1px solid #ddd;"></span>
                                                <?php else: ?>
                                                    --
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="الإجمالي"><?= number_format($itemTotal, 2) ?> ج.م</td>
                                            <td>
                                                <button class="delete-btn"
                                                    onclick="window.location.href='?delid=<?= $row['cartId'] ?>'">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card mb-4">
                        <h5 class="mb-4 fw-bold text-center">ملخص الطلب</h5>
                        <div class="summary-row">
                            <span>عدد المنتجات</span>
                            <span><?= $itemCount ?></span>
                        </div>
                        <div class="summary-row">
                            <span>مجموع السلع</span>
                            <span><?= number_format($total, 2) ?> ج.م</span>
                        </div>
                        <div class="summary-row">
                            <span>الشحن</span>
                            <span>يتم حسابه لاحقاً</span>
                        </div>
                        <div class="summary-row">
                            <span>الإجمالي</span>
                            <span><?= number_format($total, 2) ?> ج.م</span>
                        </div>
                    </div>

                    <a href="checkout.php" class="btn checkout-btn">
                        اتمام الشراء <i class="fas fa-arrow-left ms-2"></i>
                    </a>

                    <a href="index.php" class="btn btn-outline-primary w-100 mt-3">
                        <i class="fas fa-shopping-bag me-2"></i> متابعة التسوق
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h4 class="mb-3">سلة التسوق فارغة</h4>
                <p class="text-muted">لم تقم بإضافة أي منتجات إلى سلة التسوق بعد</p>
                <a href="index.php" class="continue-shopping">
                    <i class="fas fa-arrow-right me-2"></i> تصفح المنتجات
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once('inc/footer.php'); ?>