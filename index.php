<?php
require_once('core/config.php');
require_once('inc/header.php');
$user = null;
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
if($user != null) { 
    if (isset($_GET['favorite'])) {
        $product = $_GET['favorite'];
        $query = "INSERT INTO favorite (productId, userId) value ('$product', '$user')";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit;
    }
    if (isset($_GET['unfavorite'])) {
        $product = $_GET['unfavorite'];
        $query = "DELETE FROM favorite where favId = '$product'";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit;
    }
}


if (!empty($_SESSION['error']['login'])) {
    echo "<div class='alert alert-danger' role='alert' style='text-align: center'>
            {$_SESSION['error']['login']}
          </div>";
    $_SESSION['error']['login'] = null;
}


$offsetMany = "SELECT COUNT(*) as count FROM products";
$resultMany = $conn->query($offsetMany);
$pages = ceil((mysqli_fetch_assoc($resultMany)['count'])/4); // عرض 8 منتجات في الصفحة
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($pages < $page) {
    header('Location: index.php?page='. $pages);
    exit;
}

$offset = ($page - 1) * 4;


?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TrendEasy - المتجر الإلكتروني</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --success: #4cc9f0;
            --danger: #e63946;
            --warning: #f8961e;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
        }
        
        /* رأس الصفحة */
        .hero-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 6rem 0 4rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-weight: 800;
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-right: auto;
            margin-left: auto;
        }
        
        /* شبكة المنتجات */
        .products-container {
            padding: 0 1.5rem;
            margin-bottom: 4rem;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 3;
            display: flex;
            gap: 0.5rem;
        }
        
        .favorite-btn {
            background: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .favorite-btn:hover {
            transform: scale(1.1);
        }
        
        .favorite-btn i {
            color: var(--danger);
            font-size: 1.1rem;
        }
        
        .product-image {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-content {
            padding: 1.5rem;
        }
        
        .product-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-size: 1.1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3em;
        }
        
        .product-price {
            font-size: 1.25rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .product-price .old-price {
            font-size: 0.9rem;
            color: var(--gray);
            text-decoration: line-through;
            margin-right: 0.5rem;
        }
        
        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        
        .btn-details {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            flex-grow: 1;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-details:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-details i {
            font-size: 0.9rem;
        }
        
        /* التصفّح */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 3rem 0;
            flex-wrap: wrap;
        }
        
        .page-link {
            padding: 0.7rem 1.2rem;
            background-color: white;
            color: var(--dark);
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid var(--light-gray);
            transition: var(--transition);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
        }
        
        .page-link:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .page-link.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .page-link.disabled {
            pointer-events: none;
            opacity: 0.5;
            background-color: var(--light-gray);
        }
        
        /* رسائل التنبيه */
        .alert-message {
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 10px;
        }
        
        /* التكيف مع الشاشات الصغيرة */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .product-image {
                height: 180px;
            }
        }
        
        @media (max-width: 576px) {
            .hero-section {
                padding: 4rem 0 3rem;
            }
            
            .hero-title {
                font-size: 1.8rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .page-link {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- قسم الهيرو -->
    <section class="hero-section text-center">
        <div class="container hero-content">
            <h1 class="hero-title animate__animated animate__fadeInDown">أهلاً بك في TrendEasy</h1>
            <p class="hero-subtitle animate__animated animate__fadeIn animate__delay-1s">اكتشف أحدث المنتجات بأسعار تنافسية وجودة عالية</p>
        </div>
    </section>

    <!-- قسم المنتجات -->
    <section class="products-container">
        <div class="container">
            <div class="products-grid">
                <?php
                $query = "SELECT products.productId, products.userId, products.cateId, products.productName, 
                                 products.price, products.discription, favorite.favId 
                          FROM `products` 
                          LEFT JOIN favorite ON products.productId = favorite.productId 
                          LIMIT 4 OFFSET $offset";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)):
                    $productId = $row['productId'];
                    $query1 = "SELECT * FROM `image` WHERE productId = '$productId'";
                    $result1 = mysqli_query($conn, $query1);
                    $imageRow = mysqli_fetch_assoc($result1);
                    $imagePath = isset($imageRow['imagePath']) ? "images/" . $imageRow['imagePath'] : "https://via.placeholder.com/300x300?text=TrendEasy";
                    ?>
                    <div class="product-card animate__animated animate__fadeIn">
                        <!-- زر المفضلة -->
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="product-badge">
                                <?php if (empty($row['favId'])): ?>
                                    <a href="headers/favorite.php?favorite=<?= $productId ?>" class="favorite-btn" title="إضافة إلى المفضلة">
                                        <i class="far fa-heart"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="headers/favorite.php?unfavorite=<?= $row['favId'] ?>" class="favorite-btn" title="إزالة من المفضلة">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- صورة المنتج -->
                        <div class="product-image">
                            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['productName']) ?>" loading="lazy">
                        </div>

                        <!-- محتوى البطاقة -->
                        <div class="product-content">
                            <h3 class="product-title"><?= htmlspecialchars($row['productName']) ?></h3>
                            <div class="product-price">
                                <?= number_format($row['price'], 2) ?> ج.م
                            </div>
                            <div class="product-actions">
                                <a href="product.php?id=<?= $row['productId'] ?>" class="btn-details">
                                    <i class="fas fa-eye"></i> عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- التصفّح بين الصفحات -->
            <div class="pagination">
                <a href="?page=<?= $page+1 ?>" class="page-link <?= $page == $pages ? 'disabled' : '' ?>">
                    التالي <i class="fas fa-arrow-left"></i>
                </a>
                
                <?php
                // عرض أرقام الصفحات مع تحديد الصفحة الحالية
                $startPage = max(1, $page - 2);
                $endPage = min($pages, $page + 2);
                
                if ($startPage > 1) {
                    echo '<a href="?page=1" class="page-link">1</a>';
                    if ($startPage > 2) {
                        echo '<span class="page-link disabled">...</span>';
                    }
                }
                
                for ($i = $startPage; $i <= $endPage; $i++) {
                    $active = $page == $i ? 'active' : '';
                    echo "<a href='?page=$i' class='page-link $active'>$i</a>";
                }
                
                if ($endPage < $pages) {
                    if ($endPage < $pages - 1) {
                        echo '<span class="page-link disabled">...</span>';
                    }
                    echo "<a href='?page=$pages' class='page-link'>$pages</a>";
                }
                ?>
                
                <a href="?page=<?= $page-1 ?>" class="page-link <?= $page == 1 ? 'disabled' : '' ?>">
                    <i class="fas fa-arrow-right"></i> السابق
                </a>
            </div>
        </div>
    </section>

    <?php require_once('inc/footer.php'); ?>

    <script>
        // إضافة تأثيرات حركية عند التمرير
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__fadeInUp');
                    }
                });
            }, { threshold: 0.1 });
            
            productCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>