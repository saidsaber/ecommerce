<?php
include("core/config.php");
include("inc/header.php");

// التأكد من وجود ID للمنتج
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = intval($_GET['id']);

// عرض رسالة الخطأ إذا لم يكن المستخدم مسجل دخول
if (!empty($_SESSION['error']['login'])) {
    echo "<div class='alert alert-danger text-center'>{$_SESSION['error']['login']}</div>";
    $_SESSION['error']['login'] = null;
}
?>

<style>
    .con {
        min-height: calc(100vh - 56px);
        display: grid;
        align-items: center;
        margin: 10px 0;
    }
    .col {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .masterImage {
        position: relative;
    }
    #click1, #click2 {
        display: block;
        background: transparent;
        width: 50%;
        height: 100%;
        position: absolute;
        top: 0;
        cursor: pointer;
    }
    #click1 { right: 0; }
    #click2 { left: 0; }

    .extraImage {
        display: flex;
        gap: 5px;
        margin-top: 10px;
        overflow-x: auto;
    }
    .extraImage img {
        height: 60px;
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .name {
        font-weight: bold;
        font-size: 1.5rem;
        margin-top: 20px;
    }

    .description {
        margin-top: 10px;
        color: #555;
    }

    @media (max-width: 480px) {
        .row {
            flex-direction: column;
        }
    }
</style>

<div class="con">
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
        <div class="row">
            <!-- عرض الصور -->
            <div class="col">
                <div class="masterImage mb-3">
                    <img src="images/<?= htmlspecialchars($images[0]) ?>" class="card-img-top" alt="الصورة الرئيسية" id="images">
                    <span id="click1"></span>
                    <span id="click2"></span>
                </div>
                <div class="extraImage">
                    <?php foreach ($images as $img): ?>
                        <img src="images/<?= htmlspecialchars($img) ?>" class="image" alt="صورة إضافية">
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- معلومات المنتج -->
            <div class="col">
                <p class="name"><?= htmlspecialchars($row['productName']) ?></p>
                <p class="description"><?= nl2br(htmlspecialchars($row['discription'])) ?></p>

                <!-- زر الإضافة إلى السلة -->
                <form action="headers/addToCart.php" method="post">
                    <input type="hidden" name="productId" value="<?= $row['productId'] ?>">
                    <button class="btn btn-outline-dark mt-3 w-100">أضف إلى السلة</button>
                </form>
            </div>
        </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">المنتج غير موجود</div>
        <?php endif; ?>
    </div>
</div>

<?php include("inc/footer.php"); ?>

<!-- JavaScript الخاص بتغيير الصور -->
<script>
    const imageThumbs = document.querySelectorAll('.image');
    const mainImage = document.getElementById('images');
    const clickRight = document.getElementById('click1');
    const clickLeft = document.getElementById('click2');
    let currentIndex = 0;

    const updateMainImage = (index) => {
        mainImage.src = imageThumbs[index].src;
        currentIndex = index;
    }

    imageThumbs.forEach((img, index) => {
        img.onclick = () => updateMainImage(index);
    });

    clickRight.onclick = () => {
        currentIndex = (currentIndex + 1) % imageThumbs.length;
        updateMainImage(currentIndex);
    }

    clickLeft.onclick = () => {
        currentIndex = (currentIndex - 1 + imageThumbs.length) % imageThumbs.length;
        updateMainImage(currentIndex);
    }
</script>
