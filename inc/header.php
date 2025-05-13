<?php
session_start();
require_once('core/config.php');
require_once('inc/header.php');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TrendEasy - الصفحة الرئيسية</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- الخطوط -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- مكتبة Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- أيقونات Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- مكتبة animate.css للحركات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --danger-color: #e63946;
            --success-color: #4cc9f0;
            --text-color: #2b2d42;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
        }
        
        .navbar {
            background-color: white;
            box-shadow: var(--shadow);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }
        
        .navbar-brand span {
            color: var(--text-color);
        }
        
        .navbar-nav .nav-item {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background-color: var(--primary-color);
            border-radius: 50%;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.8rem;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .btn-nav {
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-login:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .btn-logout {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-logout:hover {
            background-color: #c1121f;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.2);
        }
        
        .btn-cart {
            position: relative;
            background-color: white;
            color: var(--text-color);
            border: 1px solid #eee;
            padding: 0.5rem 1rem;
        }
        
        .btn-cart:hover {
            background-color: var(--light-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        @media (max-width: 991px) {
            .navbar-collapse {
                background-color: white;
                padding: 1rem;
                border-radius: 12px;
                box-shadow: var(--shadow);
                margin-top: 1rem;
            }
            
            .nav-buttons {
                margin-top: 1rem;
                justify-content: center;
            }
            
            .dropdown-menu {
                margin: 0.5rem 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

<!-- شريط التنقل المحدث -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand animate__animated animate__fadeIn" href="index.php">
            <i class="bi bi-shop me-2"></i>Trend<span>Easy</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="تبديل التنقل">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item animate__animated animate__fadeInDown">
                    <a class="nav-link active" href="index.php">الرئيسية</a>
                </li>

                <li class="nav-item dropdown animate__animated animate__fadeInDown animate__delay-1s">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        التصنيفات
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <?php
                            $queryCatigory = "SELECT * FROM catigory";
                            $resultCatigory = mysqli_query($conn, $queryCatigory);
                            while($rowCatigory = mysqli_fetch_assoc($resultCatigory)):
                        ?>
                        <li>
                            <a class="dropdown-item" href="category.php?id=<?= $rowCatigory['cateId'] ?>">
                                <i class="bi bi-tag-fill me-2" style="color: <?= sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>"></i>
                                <?= $rowCatigory['cateName'] ?>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </li>

                <li class="nav-item animate__animated animate__fadeInDown animate__delay-2s">
                    <a class="nav-link" href="favorite.php">
                        <i class="bi bi-heart me-1"></i> المفضلة
                    </a>
                </li>
            </ul>

            <div class="nav-buttons">
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="headers/logout.php" class="btn btn-logout btn-nav animate__animated animate__fadeInDown animate__delay-3s">
                        <i class="bi bi-box-arrow-left"></i> تسجيل الخروج
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-login btn-nav animate__animated animate__fadeInDown animate__delay-3s">
                        <i class="bi bi-person"></i> تسجيل الدخول
                    </a>
                <?php endif; ?>

                <form action="cart.php" method="post" class="animate__animated animate__fadeInDown animate__delay-4s">
                    <button class="btn btn-cart" type="submit">
                        <i class="bi bi-cart3"></i>
                        <?php
                            $number = 0;
                            if(isset($_SESSION['user'])){
                                $query = "SELECT COUNT(*) as number FROM cart where userId = '{$_SESSION['user']}' and shipmentId = '0'";
                                $result = mysqli_query($conn, $query);
                                $number = $row = mysqli_fetch_assoc($result)["number"];
                            }
                        ?>
                        <span class="cart-badge"><?= $number ?></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // إضافة تأثير التمرير لشريط التنقل
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>