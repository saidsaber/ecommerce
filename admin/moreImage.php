<?php
include('../core/config.php');

// تفعيل عرض الأخطاء للتسهيل أثناء التطوير (إزالتها في الإنتاج)
error_reporting(E_ALL);
ini_set('display_errors', 1);
$id =  $_GET['productId'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveImage'])) {
    echo $id;
    // التحقق من وجود ID وكونه رقمي

    $id = intval($_GET['productId']);
    $path = saveImage();

    if ($path) {
        // استخدام Prepared Statements لحماية من حقن SQL
        $query = "INSERT INTO `image` (productId, imagePath) VALUES (?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('خطأ في إعداد الاستعلام: ' . $conn->error);
        }

        $stmt->bind_param("is", $id, $path);

        if ($stmt->execute()) {
            header("Location: updata_Product.php");
            exit();
        } else {
            die('خطأ في تنفيذ الاستعلام: ' . $stmt->error);
        }
    } else {
        die('فشل في رفع الصورة');
    }
}

function saveImage()
{
    // التحقق من وجود ملف مرفوع
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die('خطأ في رفع الملف: ' . ($_FILES['image']['error'] ?? 'لم يتم رفع ملف'));
    }

    // التحقق من نوع الملف
    $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
    finfo_close($fileInfo);

    if (!array_key_exists($fileType, $allowedTypes)) {
        die('نوع الملف غير مسموح به. يسمح فقط ب: ' . implode(', ', $allowedTypes));
    }

    // إنشاء اسم فريد للملف
    $extension = $allowedTypes[$fileType];
    $name = uniqid('img_') . '.' . $extension;
    $uploadDir = '../images/';

    // إنشاء المجلد إذا لم يكن موجوداً
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $targetPath = $uploadDir . $name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        return $name;
    } else {
        die('فشل في نقل الملف إلى المجلد المخصص');
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفع صورة المنتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tajawal', sans-serif;
        }

        .upload-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .upload-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }

        .form-title {
            color: #4e73df;
            margin-bottom: 20px;
            text-align: center;
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .file-upload:hover {
            border-color: #4e73df;
            background: #f8faff;
        }

        .btn-upload {
            background: #4e73df;
            color: white;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-upload:hover {
            background: #2e59d9;
        }

        .preview-img {
            max-width: 100%;
            max-height: 200px;
            margin-top: 15px;
            display: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="upload-container">
        <div class="upload-box">
            <h3 class="form-title">رفع صورة جديدة للمنتج</h3>

            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">

                <label class="file-upload">
                    <input type="file" name="image" id="imageInput" accept="image/*" required style="display: none;">
                    <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #4e73df;"></i>
                    <p id="fileLabel">انقر لاختيار صورة أو اسحبها هنا</p>
                    <small>الملفات المسموحة: JPG, PNG, GIF</small>
                    <img id="imagePreview" class="preview-img">
                </label>

                <button type="submit" name="saveImage" class="btn-upload">
                    <i class="fas fa-upload me-2"></i> رفع الصورة
                </button>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // عرض معاينة الصورة
        document.getElementById('imageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                    document.getElementById('fileLabel').textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>