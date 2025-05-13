<?php
require_once('core/config.php');
require_once('inc/header.php');
$user = null;
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if (isset($_GET['unfavorite'])) {
    $product = $_GET['unfavorite'];

    $query = "DELETE FROM favorite where favId = '$product'";
    mysqli_query($conn, $query);
    // header("Location: index.php");
    exit;
}

if (!empty($_SESSION['error']['login'])) {
    echo "
                <div class='alert alert-danger' role='alert' style='text-align: center'>
                    {$_SESSION['error']['login']}
                    </div>
                    ";
    $_SESSION['error']['login'] = null;
}
if (!isset($_SESSION['user'])) {
    echo "
            <div class='alert alert-danger text-center'>
                يجب عليك <a href='login.php'>تسجيل الدخول</a> أولاً
            </div>
        ";
    exit;
}
?>

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
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
    <!-- رأس الصفحة -->
    <section class="hero-section text-center">
        <div class="container hero-content">
            <h1 class="hero-title animate__animated animate__fadeInDown">أهلاً بك في TrendEasy</h1>
            <p class="hero-subtitle animate__animated animate__fadeIn animate__delay-1s">اكتشف أحدث المنتجات بأسعار تنافسية وجودة عالية</p>
        </div>
    </section>

    <!-- شبكة المنتجات -->
    <main class="container mb-5">
        <div class="products-grid">
            <?php
            include("core/config.php");
            $query = "SELECT products.productId , products.userId , products.cateId , products.productName , products.price , products.discription , favorite.favId FROM `products` inner JOIN favorite ON products.productId = favorite.productId;";

            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)):
                $productId = $row['productId'];
                $query1 = "SELECT * FROM `image` WHERE productId = '$productId'";
                $result1 = mysqli_query($conn, $query1);
                $imageRow = mysqli_fetch_assoc($result1);
                $imagePath = isset($imageRow['imagePath']) ? "images/" . $imageRow['imagePath'] : "placeholder.jpg";
                ?>
                <div class="product-card">
                    <!-- زر المفضلة -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="product-badge">
                            <?php if (empty($row['favId'])): ?>
                                <a href="headers/favorite.php?favorite=<?= $productId ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172V3.84172Z"
                                            stroke="#eee" fill="transparent" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            <?php else: ?>
                                <a href="headers/favorite.php?unfavorite=<?= $row['favId'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172V3.84172Z"
                                            stroke="red" fill="red" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- صورة المنتج -->
                    <div class="product-image">
                        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['productName']) ?>">
                    </div>

                    <!-- محتوى البطاقة -->
                    <div class="product-content">
                        <h3 class="product-title"><?= htmlspecialchars($row['productName']) ?></h3>
                        <div class="product-price"><?= $row['price'] ?> جنيه</div>
                        <div class="product-actions">
                            <a href="product.php?id=<?= $row['productId'] ?>" class="btn-details">عرض التفاصيل</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php require_once('inc/footer.php'); ?>