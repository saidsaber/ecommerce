<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}
include("core/config.php");
include("inc/header.php");

$id = intval($_GET['id']);

if (!empty($_SESSION['error']['login'])) {
    echo "<div class='alert alert-danger text-center'>{$_SESSION['error']['login']}</div>";
    $_SESSION['error']['login'] = null;
}

function reverColor($textColor)
{
    list($r, $g, $b) = sscanf($textColor, "#%02x%02x%02x");
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    return ($luminance > 0.5) ? '#000000' : '#ffffff';
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TrendEasy - تفاصيل المنتج</title>
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
            --danger: #e63946;
            --success: #4cc9f0;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
        }

        /* قسم المنتج الرئيسي */
        .product-section {
            padding: 3rem 0;
        }

        .product-container {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* معرض الصور */
        .gallery-container {
            position: relative;
            padding: 2rem;
        }

        .main-image-container {
            position: relative;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            cursor: zoom-in;
        }

        .main-image {
            width: 100%;
            height: 450px;
            object-fit: contain;
            transition: var(--transition);
        }

        .main-image:hover {
            transform: scale(1.02);
        }

        .thumbnails-container {
            display: flex;
            gap: 0.8rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .gallery-nav {
            position: absolute;
            top: 50%;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transform: translateY(-50%);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .gallery-nav:hover {
            background-color: white;
            transform: translateY(-50%) scale(1.1);
        }

        .gallery-prev {
            right: 30px;
        }

        .gallery-next {
            left: 30px;
        }

        /* معلومات المنتج */
        .product-info {
            padding: 2rem;
        }

        .product-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .product-description {
            color: var(--gray);
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        /* خيارات المنتج */
        .variant-section {
            margin-bottom: 2rem;
        }

        .variant-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .variant-options {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
        }

        .variant-option {
            position: relative;
        }

        .variant-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .variant-option label {
            display: block;
            padding: 0.6rem 1.2rem;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .variant-option input[type="radio"]:checked+label {
            border-color: var(--primary);
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-weight: 600;
        }

        .color-option label {
            min-width: 80px;
            text-align: center;
        }

        .color-option input[type="radio"]:checked+label {
            box-shadow: 0 0 0 2px white, 0 0 0 4px var(--primary);
        }

        .size-option label {
            min-width: 50px;
            text-align: center;
        }

        .size-option input[type="radio"]:checked+label {
            background-color: var(--primary);
            color: white !important;
            border-color: var(--primary);
        }

        /* زر الإضافة إلى السلة */
        .add-to-cart-btn {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }

        .add-to-cart-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .add-to-cart-btn:disabled {
            background-color: var(--gray) !important;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .add-to-cart-btn .spinner {
            display: none;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* رسائل التنبيه */
        .alert-message {
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 10px;
        }

        /* التكيف مع الشاشات الصغيرة */
        @media (max-width: 992px) {
            .main-image {
                height: 350px;
            }
        }

        @media (max-width: 768px) {
            .product-title {
                font-size: 1.6rem;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .main-image {
                height: 300px;
            }
        }

        @media (max-width: 576px) {
            .gallery-container {
                padding: 1rem;
            }

            .main-image {
                height: 250px;
            }

            .product-info {
                padding: 1.5rem;
            }

            .product-title {
                font-size: 1.4rem;
            }

            .gallery-nav {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .gallery-prev {
                right: 20px;
            }

            .gallery-next {
                left: 20px;
            }
        }
    </style>
</head>

<body>
    <section class="product-section">
        <div class="container">
            <?php
            $stmt = $conn->prepare("
                SELECT products.*, GROUP_CONCAT(image.imagePath) AS images
                FROM products
                INNER JOIN image ON products.productId = image.productId
                WHERE products.productId = ?
            ");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()):
                $images = explode(',', $row['images']);
                ?>
                <div class="product-container">
                    <div class="row">
                        <!-- معرض الصور -->
                        <div class="col-lg-6">
                            <div class="gallery-container">
                                <div class="main-image-container">
                                    <img src="images/<?= htmlspecialchars($images[0]) ?>" class="main-image" id="mainImage"
                                        alt="<?= htmlspecialchars($row['productName']) ?>">
                                    <div class="gallery-nav gallery-prev" id="prevBtn">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                    <div class="gallery-nav gallery-next" id="nextBtn">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                </div>

                                <div class="thumbnails-container">
                                    <?php foreach ($images as $index => $img): ?>
                                        <img src="images/<?= htmlspecialchars($img) ?>"
                                            class="thumbnail <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"
                                            alt="صورة المنتج <?= $index + 1 ?>">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات المنتج -->
                        <div class="col-lg-6">
                            <div class="product-info">
                                <h1 class="product-title"><?= htmlspecialchars($row['productName']) ?></h1>
                                <div class="product-price">
                                    <?= number_format($row['price'], 2) ?> ج.م
                                </div>
                                <p class="product-description">
                                    <?= nl2br(htmlspecialchars($row['discription'])) ?>
                                </p>

                                <form action="headers/addToCart.php" method="post" id="addToCartForm">
                                    <input type="hidden" name="productId" value="<?= $row['productId'] ?>">

                                    <?php if ($row['haveDetails'] == 1): ?>
                                        <!-- خيارات الألوان -->
                                        <div class="variant-section">
                                            <h3 class="variant-title">
                                                <i class="fas fa-palette"></i> اختر اللون
                                            </h3>
                                            <div class="variant-options" id="colorOptions">
                                                <?php
                                                $getcolor = "SELECT * FROM color WHERE productId = {$row['productId']}";
                                                $colorRes = mysqli_query($conn, $getcolor);
                                                $firstColor = true;
                                                while ($rowcolor = mysqli_fetch_assoc($colorRes)):
                                                    ?>
                                                    <div class="variant-option color-option">
                                                        <input type="radio" name="colorId" id="color<?= $rowcolor['colorId'] ?>"
                                                            value="<?= $rowcolor['colorId'] ?>" <?= $firstColor ? 'checked' : '' ?>>
                                                        <label for="color<?= $rowcolor['colorId'] ?>"
                                                            style="background-color:<?= $rowcolor['colorHexCode'] ?>; 
                                                                      color: <?= reverColor($rowcolor['colorHexCode']) ?>;">
                                                            <?= $rowcolor['colorName'] ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    $firstColor = false;
                                                endwhile; ?>
                                            </div>
                                        </div>

                                        <!-- خيارات المقاسات -->
                                        <div class="variant-section">
                                            <h3 class="variant-title">
                                                <i class="fas fa-ruler-combined"></i> اختر المقاس
                                            </h3>
                                            <div class="variant-options" id="sizeOptions">
                                                <?php
                                                $getsize = "SELECT * FROM size WHERE productId = {$row['productId']}";
                                                $sizeRes = mysqli_query($conn, $getsize);
                                                $firstSize = true;
                                                while ($rowsize = mysqli_fetch_assoc($sizeRes)):
                                                    ?>
                                                    <div class="variant-option size-option">
                                                        <input type="radio" name="sizeId" id="size<?= $rowsize['sizeId'] ?>"
                                                            value="<?= $rowsize['sizeId'] ?>" <?= $firstSize ? 'checked' : '' ?>>
                                                        <label for="size<?= $rowsize['sizeId'] ?>">
                                                            <?= $rowsize['sizeName'] ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    $firstSize = false;
                                                endwhile; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <button type="submit" class="add-to-cart-btn" id="addToCartBtn">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>أضف إلى السلة</span>
                                        <i class="fas fa-spinner spinner"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center py-4">
                    <i class="fas fa-exclamation-triangle me-2"></i> المنتج غير موجود
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
        // معرض الصور
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        // تحديث الصورة الرئيسية
        const updateMainImage = (index) => {
            mainImage.src = thumbnails[index].src;
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            thumbnails[index].classList.add('active');
            currentIndex = index;
        }

        // النقر على الصور المصغرة
        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', () => updateMainImage(index));
        });

        // السهم السابق
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            updateMainImage(currentIndex);
        });

        // السهم التالي
        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % thumbnails.length;
            updateMainImage(currentIndex);
        });

        // التنقل باستخدام لوحة المفاتيح
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') prevBtn.click();
            else if (e.key === 'ArrowLeft') nextBtn.click();
        });

        // تكبير الصورة عند النقر
        mainImage.addEventListener('click', () => {
            window.open(mainImage.src, '_blank');
        });

        // إدارة حالة زر الإضافة إلى السلة
        const addToCartForm = document.getElementById('addToCartForm');
        const addToCartBtn = document.getElementById('addToCartBtn');

        <?php if ($row['haveDetails'] == 1): ?>
            const colorOptions = document.querySelectorAll('input[name="colorId"]');
            const sizeOptions = document.querySelectorAll('input[name="sizeId"]');

            // تحديث حالة الزر عند تغيير الخيارات
            function updateAddToCartButton() {
                const colorSelected = document.querySelector('input[name="colorId"]:checked');
                const sizeSelected = document.querySelector('input[name="sizeId"]:checked');

                if (colorSelected && sizeSelected) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.querySelector('span').textContent = 'أضف إلى السلة';
                } else {
                    addToCartBtn.disabled = true;
                    addToCartBtn.querySelector('span').textContent = 'اختر اللون والمقاس';
                }
            }

            // إضافة مستمعات الأحداث
            colorOptions.forEach(option => {
                option.addEventListener('change', updateAddToCartButton);
            });

            sizeOptions.forEach(option => {
                option.addEventListener('change', updateAddToCartButton);
            });

            // التهيئة الأولية
            updateAddToCartButton();
        <?php endif; ?>

        // عرض مؤشر التحميل عند الإرسال
        addToCartForm.addEventListener('submit', function () {
            const btnText = addToCartBtn.querySelector('span');
            const spinner = addToCartBtn.querySelector('.spinner');
            const cartIcon = addToCartBtn.querySelector('.fa-shopping-cart');

            btnText.textContent = 'جاري الإضافة...';
            cartIcon.style.display = 'none';
            spinner.style.display = 'block';
            addToCartBtn.disabled = true;
        });
    </script>

    <?php include("inc/footer.php"); ?>
</body>

</html>