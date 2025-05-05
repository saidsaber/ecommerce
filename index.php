<?php
    require_once ('core/config.php'); 
    require_once ('inc/header.php'); 
    $user = null;
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    if(isset($_GET['favorite'])){
        $product = $_GET['favorite'];

        $query = "INSERT INTO favorite (productId , userId) value ('$product' , '$user')";
        mysqli_query($conn , $query);
        header("Location: index.php");
        exit;
    }
    if(isset($_GET['unfavorite'])){
        $product = $_GET['unfavorite'];

        $query = "DELETE FROM favorite where favId = '$product'";
        mysqli_query($conn , $query);
        header("Location: index.php");
        exit;
    }

    if(!empty($_SESSION['error']['login'])){
        echo "
                <div class='alert alert-danger' role='alert' style='text-align: center'>
                    {$_SESSION['error']['login']}
                    </div>
                    ";
        $_SESSION['error']['login'] = null;
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
    </style>
</head>
<body>
    <!-- رأس الصفحة -->
    <header class="products-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">منتجاتنا</h1>
            <p class="lead">اكتشف أحدث منتجاتنا بأسعار تنافسية</p>
        </div>
    </header>

    <!-- شبكة المنتجات -->
    <main class="container mb-5">
        <div class="products-grid">
            <?php
            include("core/config.php");
            $query = "SELECT products.productId, products.userId, products.cateId, products.productName, 
                             products.price, products.discription, favorite.favId 
                      FROM `products` 
                      LEFT JOIN favorite ON products.productId = favorite.productId";
            $result = mysqli_query($conn, $query);
            
            while($row = mysqli_fetch_assoc($result)):
                $productId = $row['productId'];
                $query1 = "SELECT * FROM `image` WHERE productId = '$productId'";
                $result1 = mysqli_query($conn, $query1);
                $imageRow = mysqli_fetch_assoc($result1);
                $imagePath = isset($imageRow['imagePath']) ? "images/" . $imageRow['imagePath'] : "placeholder.jpg";
            ?>
            <div class="product-card">
                <!-- زر المفضلة -->
                <?php if(isset($_SESSION['user'])): ?>
                    <div class="product-badge">
                        <?php if(empty($row['favId'])): ?>
                            <a href="?favorite=<?= $productId ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172V3.84172Z" 
                                          stroke="#eee" fill="transparent" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php else: ?>
                            <a href="?unfavorite=<?= $row['favId'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 20 20" fill="none">
                                    <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172V3.84172Z" 
                                          stroke="red" fill="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
<?php require_once ('inc/footer.php'); ?>