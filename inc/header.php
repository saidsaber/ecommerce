<?php
    session_start();
    require_once ('core/config.php'); 
    require_once ('inc/header.php'); 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TrendEasy - الصفحة الرئيسية</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
        }
        .navbar {
            background-color: var(--light-color);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color);
        }
        .navbar-nav .nav-link {
            color: var(--primary-color);
        }
        .navbar-nav .nav-link:hover {
            color: var(--secondary-color);
        }
        .btn-outline-dark {
            display: flex;
            align-items: center;
        }
        .navbar .btn a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

<!-- شريط التنقل -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">TrendEasy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="تبديل التنقل">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">الرئيسية</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        التصنيفات
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <?php
                            $queryCatigory = "SELECT * FROM catigory";
                            $resultCatigory = mysqli_query($conn , $queryCatigory);
                            while($rowCatigory = mysqli_fetch_assoc($resultCatigory)):
                        ?>
                        <li><a class="dropdown-item" href="category.php?id=<?= $rowCatigory['cateId'] ?>"><?= $rowCatigory['cateName'] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="favorite.php">المفضلة</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="headers/logout.php" class="btn btn-outline-danger">تسجيل الخروج</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary">تسجيل الدخول</a>
                <?php endif; ?>

                <form action="cart.php" method="post" class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi bi-cart-fill me-1"></i>
                        السلة
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

