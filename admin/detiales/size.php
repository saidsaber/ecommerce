<?php
session_start();
include("../../core/main.php");
include("../../core/config.php");
if(!isset($_POST["id"])){
    header("Location: ../Updata_Product.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>إضافة مقاس جديد</title>
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
            max-width: 400px;
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
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }
        
        .form-input:focus {
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
        
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="form-container">
            <h2 class="form-title">إضافة مقاس جديد</h2>
            <form action="../../headers/size.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_POST['id']) ?>">
                
                <div class="form-group">
                    <input type="text" name="size" class="form-input" placeholder="أدخل المقاس (مثال: XL, L, M, S)" required>
                </div>
                
                <button type="submit" name="saveSize" class="submit-btn">حفظ المقاس</button>
                <a href="../Updata_Product.php" class="back-btn">العودة إلى صفحة المنتجات</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>