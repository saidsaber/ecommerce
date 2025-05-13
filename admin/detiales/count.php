<?php
include("../../core/config.php");

$queryColors = "SELECT * FROM `color` WHERE productId = {$_POST['id']}";
$querySizes = "SELECT * FROM `size` WHERE productId = {$_POST['id']}";

$resultColors = mysqli_query($conn, $queryColors);
$resultSizes = mysqli_query($conn, $querySizes);

$data = [
    'color' => [],
    'size' => []
];

// معالجة الألوان
while ($row = mysqli_fetch_assoc($resultColors)) {
    $data['color'][$row['colorId']] = $row;
}

// معالجة المقاسات
while ($row = mysqli_fetch_assoc($resultSizes)) {
    $data['size'][$row['sizeId']] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin Panel</title>
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --hover-color: #2e59d9;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #5a5c69;
        }
        
        .form-select, .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: border-color 0.3s;
        }
        
        .form-select:focus, .form-input:focus {
            border-color: var(--primary-color);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            border: none;
            border-radius: 0.35rem;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: var(--hover-color);
        }
        
        /* تحسينات للعرض على الأجهزة الصغيرة */
        @media (max-width: 576px) {
            .form-container {
                padding: 1.5rem;
                margin: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="form-container">
            <h2 class="form-title">إدارة المخزون</h2>
            <form action="../../headers/count.php" method="post">
                <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                
                <div class="form-group">
                    <label for="color" class="form-label">اختر اللون</label>
                    <select name="color" id="color" class="form-select">
                        <option value="">-- اختر لون --</option>
                        <?php
                        foreach ($data['color'] as $value) :
                        ?>
                        <option value="<?=$value['colorId']?>"><?=$value['colorName']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="size" class="form-label">اختر المقاس</label>
                    <select name="size" id="size" class="form-select">
                        <option value="">-- اختر مقاس --</option>
                        <?php
                        foreach ($data['size'] as $value) :
                        ?>
                        <option value="<?=$value['sizeId']?>"><?=$value['sizeName']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="count" class="form-label">الكمية</label>
                    <input type="text" name="count" id="count" class="form-input" placeholder="أدخل الكمية">
                </div>
                
                <button type="submit" name="saveCount" class="submit-btn">حفظ البيانات</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>