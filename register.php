<?php
session_start();
include("core/main.php");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --main-color: #3498db;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --danger-color: #e74c3c;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .register-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(to right, var(--main-color), var(--dark-color));
            color: white;
            padding: 20px;
            text-align: center;
        }

        .register-body {
            padding: 25px;
            background: white;
        }

        .form-control {
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .input-group-text {
            background-color: #f1f1f1;
            border: 1px solid #ddd;
        }

        .btn-register {
            background-color: var(--main-color);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
            padding: 10px 15px;
        }

        .password-toggle {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 5;
        }

        .password-container {
            position: relative;
        }

        .register-footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .register-footer a {
            color: var(--main-color);
            font-weight: 500;
            text-decoration: none;
        }

        /* Fixes for RTL */
        .input-group>.form-control {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
        }

        .input-group-text {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h4><i class="fas fa-user-plus me-2"></i>إنشاء حساب جديد</h4>
            </div>

            <div class="register-body">
                <form method="post" action="headers/register.php">
                    <!-- الاسم -->
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="name" name="name" placeholder="أدخل اسمك الكامل"
                                value="<?= old('name') ?>">
                        </div>
                        <div class="alert alert-danger mt-2" style="display: <?= show('name') ?>">
                            <i class="fas fa-exclamation-circle me-2"></i><?= error('name') ?>
                        </div>
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="example@example.com" value="<?= old('email') ?>">
                        </div>
                        <div class="alert alert-danger mt-2" style="display: <?= show('email') ?>">
                            <i class="fas fa-exclamation-circle me-2"></i><?= error('email') ?>
                        </div>
                    </div>

                    <!-- الهاتف -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="05XXXXXXXX"
                                value="<?= old('phone') ?>">
                        </div>
                        <div class="alert alert-danger mt-2" style="display: <?= show('phone') ?>">
                            <i class="fas fa-exclamation-circle me-2"></i><?= error('phone') ?>
                        </div>
                    </div>

                    <!-- كلمة المرور -->
                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <div class="password-container">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="كلمة المرور" value="<?= old('password') ?>">
                                <span class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <div class="alert alert-danger mt-2" style="display: <?= show('password') ?>">
                                <i class="fas fa-exclamation-circle me-2"></i><?= error('password') ?>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="save" class="btn btn-register mt-3">
                        <i class="fas fa-user-plus me-2"></i>تسجيل الحساب
                    </button>
                </form>
            </div>

            <div class="register-footer">
                <p class="mb-0">لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.password-toggle i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php $_SESSION['error'] = null; ?>