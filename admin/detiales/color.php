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
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>إضافة لون جديد</title>
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #f8f9fc;
            --dark: #5a5c69;
            --light: #fff;
            --border: #d1d3e2;
        }
        
        body {
            background-color: var(--secondary);
            font-family: 'Tajawal', sans-serif;
        }
        
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 2rem;
            background: var(--light);
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .form-title {
            color: var(--primary);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .color-preview {
            width: 100%;
            height: 50px;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border);
        }
        
        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: #2e59d9;
        }
        
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
            <h2 class="form-title">إضافة لون جديد</h2>
            <form action="../../headers/color.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_POST['id']) ?>">
                
                <div class="form-group">
                    <label for="color" class="form-label">اسم اللون</label>
                    <input type="text" name="color" id="" class="form-control" placeholder="أدخل اسم اللون" required>
                </div>
                
                <div class="form-group">
                    <label for="colorHexCod" class="form-label">كود اللون (HEX)</label>
                    <small class="text-muted">أدخل كود اللون بصيغة HEX مثل #FFFFFF</small>
                    <input type="text" name="colorHexCod" id="colorHexCod" class="form-control" 
                           placeholder="#RRGGBB" pattern="^#[0-9A-Fa-f]{6}$" required>
                </div>
                
                
                <button type="submit" name="saveColor" class="submit-btn">حفظ اللون</button>
            </form>
        </div>
    </div>

    <script>
        // عرض معاينة اللون عند إدخال الكود
        document.getElementById('colorHexCod').addEventListener('input', function() {
            const colorCode = this.value;
            const preview = document.getElementById('colorPreview');
            
            if (/^#[0-9A-Fa-f]{6}$/.test(colorCode)) {
                preview.style.backgroundColor = colorCode;
            } else {
                preview.style.backgroundColor = 'transparent';
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>